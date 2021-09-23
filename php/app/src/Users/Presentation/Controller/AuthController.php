<?php
declare(strict_types=1);

namespace App\Users\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Users\Application\Command\LoginUser;
use App\Users\Application\Command\LogOutUser;
use App\Users\Application\Command\SignUpUser;
use App\Users\Application\Query\GetAuth;
use App\Users\Application\Query\GetUserQuery;
use App\Users\Domain\DTO\User;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Infrastructure\Services\Auth\DTO\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends ApiController
{
    /**
     * @Route("/v1/auth/logout", name="logout", methods={"POST"})
     */
    public function logout(): Response
    {
        try {
            $command = new LogOutUser();

            $this->commandBus->handle($command);

            return $this->buildSuccessResponse();
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }

    /**
     * @Route("/v1/auth/{platform}", name="login", methods={"POST"})
     */
    public function auth(string $platform, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $lang = $data['lang'];

        try {
            $auth = $this->authUserByCode($platform, $data);
            $user = $this->findUserById($auth->user->id);

            if (!$user) {
                $this->registerUser($auth, $lang);

                return $this->buildSerializedResponse([
                    'registration' => true,
                    'user' => $this->findUserById($auth->user->id, $auth->user->id),
                    'subscription_token' => $auth->token,
                ]);
            }

            $this->loginUser($auth, $lang);

            return $this->buildSerializedResponse([
                'registration' => false,
                'user' => $this->findUserById($auth->user->id, $auth->user->id),
                'subscription_token' => $auth->token,
            ]);
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }

    private function findUserById(string $id, string $currentUserId = null): ?User
    {
        try {
            return $this->queryBus->handle(
                new GetUserQuery($id, $currentUserId)
            );
        } catch (UserNotFoundException $e) {
            return null;
        }
    }

    private function authUserByCode(string $platform, array $params): Auth
    {
        $query = new GetAuth($platform, $params);

        return $this->queryBus->handle($query);
    }

    private function registerUser(
        Auth $auth,
        string $lang
    ): void {
        $command = new SignUpUser(
            $auth->user->id,
            $auth->user->login,
            $lang,
            $auth->user->picture,
            $auth->user->email,
            $auth->user->name
        );

        $this->commandBus->handle($command);
    }

    private function loginUser(Auth $auth, ?string $lang): void
    {
        $command = new LoginUser($auth->user->id, $auth->user->login, $lang);

        $this->commandBus->handle($command);
    }
}
