<?php
declare(strict_types=1);

namespace App\Tasks\Application\UseCase;

use App\Tasks\Application\Command\UpdateTaskCommand;
use App\Tasks\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class UpdateTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $tasksRepository;

    public function __construct(TasksRepositoryInterface $tasksRepository)
    {
        $this->tasksRepository = $tasksRepository;
    }

    public function __invoke(UpdateTaskCommand $command): void
    {
        $task = $this->tasksRepository->get($command->getId());

        $task->update($command->getName(), $command->getStatus());

        $this->tasksRepository->add($task);
    }
}
