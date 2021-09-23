<?php
declare(strict_types=1);

namespace App\Comments\Application\UseCase;

use App\Comments\Application\Command\DeleteCommentCommand;
use App\Comments\Domain\Repository\CommentsRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class DeleteCommentCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $commentsRepository;

    public function __construct(CommentsRepositoryInterface $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    public function __invoke(DeleteCommentCommand $command): void
    {
        $comment = $this->commentsRepository->get($command->getId());

        $comment->delete();

        $this->commentsRepository->remove($comment);
    }
}