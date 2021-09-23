<?php
declare(strict_types=1);

namespace App\Tasks\Application\UseCase;

use App\Tasks\Application\Command\DeleteTaskCommand;
use App\Tasks\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class DeleteTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $tasksRepository;

    public function __construct(TasksRepositoryInterface $tasksRepository)
    {
        $this->tasksRepository = $tasksRepository;
    }

    public function __invoke(DeleteTaskCommand $command): void
    {
        $task = $this->tasksRepository->get($command->getId());

        $task->delete();

        $this->tasksRepository->remove($task);
    }
}