<?php
declare(strict_types=1);

namespace App\Users\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Kernel\Api\Response\ApiResponse;
use App\Users\Application\Query\GetUsersQuery;
use App\Users\Domain\Exception\ForbiddenException;
use App\Users\Domain\Exception\UnauthorizedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    /**
     * @Route("/v1/users", name="get_users", methods={"GET"})
     */
    public function getUsers(Request $request): Response
    {
        try {
            $users = $this->queryBus->handle(new GetUsersQuery());

            return $this->buildSerializedListResponse(
                $users,
                count($users)
            );
        } catch (UnauthorizedException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_AUTH_FAILED);
        } catch (ForbiddenException $e) {
            return $this->buildFailResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }
}
