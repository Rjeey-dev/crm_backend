<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services;

use App\Users\Domain\DataProvider\AuthInterface as AuthDataProviderInterface;
use App\Users\Domain\Exception\ForbiddenException;
use App\Users\Domain\Exception\UnauthorizedException;
use App\Users\Domain\Services\AuthInterface;
use App\Users\Domain\ValueObject\UserId;
use Symfony\Component\HttpFoundation\RequestStack;

class Auth implements AuthInterface
{
    private $auth;
    private $requestStack;

    public function __construct(AuthDataProviderInterface $auth, RequestStack $requestStack)
    {
        $this->auth = $auth;
        $this->requestStack = $requestStack;
    }

    public function authorizeUser(UserId $id): void
    {
        $token = $this->getTokenFromRequest();

        if (!$token) {
            return;
        }

        $this->auth->set($id, $token);
    }

    public function unauthorizeCurrentUser(): void
    {
        $this->auth->delete($this->getTokenFromRequest());
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentUser(): UserId
    {
        $token = $this->getTokenFromRequest();

        if (!$token) {
            throw new UnauthorizedException('Token is not provided');
        }

        return new UserId($this->auth->get($token));
    }

    private function getTokenFromRequest(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return null;
        }

        return $request->headers->get('X-Auth-Token');
    }
}
