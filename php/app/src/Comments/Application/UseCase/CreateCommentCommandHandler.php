<?php
declare(strict_types=1);

namespace App\Comments\Application\UseCase;

use App\Comments\Application\Command\CreateCommentCommand;
use App\Comments\Domain\Entity\Comment;
use App\Comments\Domain\Repository\CommentsRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class CreateCommentCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $commentsRepository;

    public function __construct(CommentsRepositoryInterface $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    public function __invoke(CreateCommentCommand $command): void
    {
        $comment = new Comment($command->getId(), $command->getText(), $command->getTaskId());

        $this->commentsRepository->add($comment);
    }
}