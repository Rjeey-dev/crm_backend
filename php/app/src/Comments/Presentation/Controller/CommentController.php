<?php
declare(strict_types=1);

namespace App\Comments\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Kernel\Api\Response\ApiResponse;
use App\Comments\Application\Command\CreateCommentCommand;
use App\Comments\Application\Command\UpdateCommentCommand;
use App\Comments\Application\Command\DeleteCommentCommand;
use App\Comments\Application\Query\FindCommentByIdQuery;
use App\Comments\Application\Query\FindCommentsQuery;
use App\Comments\Domain\DTO\CommentsList;
use App\Comments\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

class CommentController extends ApiController
{
    /**
     * @Route("/comments", name="comments", methods={"GET"})
     */
    public function list(Request $request): Response
    {
        try {
            /** @var CommentsList $commentsList */
            $commentsList = $this->queryBus->handle(new FindCommentsQuery(
                $request->query->get('task_id') !== null ? (string)$request->query->get('task_id') : null,
                $request->query->get('offset') !== null ? (int)$request->query->get('offset') : null,
                $request->query->get('limit') !== null ? (int)$request->query->get('limit') : null,
                $request->query->get('order') !== null ? (string)$request->query->get('order') : null
            ));

            return $this->buildSerializedListResponse(
                $commentsList->getComments(),
                $commentsList->getTotalCount(),
                ['comments-list']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }

    /**
     * @Route ("/comments", name="create_comment", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new CreateCommentCommand(
                (string)$data['text'],
                (string)$data['task_id']
            );

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindCommentByIdQuery($command->getId()->getId())),
                ['comment-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/comments/{id}", name="comments_delete", methods={"DELETE"})
     */
    public function delete(string $id): Response
    {
        try {
            $command = new DeleteCommentCommand($id);

            $this->commandBus->handle($command);

            return $this->buildSuccessResponse();
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/comments/{id}", name="comments_update", methods={"PATCH"})
     */
    public function update(Request $request, string $id): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new UpdateCommentCommand($id, (string) $data['text'], (string) $data['task_id']);

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindCommentByIdQuery($id)),
                ['comment-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }
}