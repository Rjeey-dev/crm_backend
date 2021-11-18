<?php

declare(strict_types=1);

namespace App\Tasks\Application\UseCase;

use App\Tasks\Application\Command\StartScheduledTaskCommand;
use App\Tasks\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class StartScheduledTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $repository;

    public function __construct(TasksRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(StartScheduledTaskCommand $command): void
    {
        $task = $this->repository->get($command->getId());

        $task->start();

        $this->repository->add($task);
    }
}
