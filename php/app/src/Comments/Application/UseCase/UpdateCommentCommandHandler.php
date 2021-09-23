<?php
declare(strict_types=1);

namespace App\Comments\Application\UseCase;

use App\Comments\Application\Command\UpdateCommentCommand;
use App\Comments\Domain\Repository\CommentsRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class UpdateCommentCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $commentsRepository;

    public function __construct(CommentsRepositoryInterface $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    public function __invoke(UpdateCommentCommand $command): void
    {
        $comment = $this->commentsRepository->get($command->getId());

        $comment->update($command->getText(),$command->getComment());

        $this->commentsRepository->add($comment);
    }
}
