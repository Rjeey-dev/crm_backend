<?php
declare(strict_types=1);

namespace App\Tasks\Application\UseCase;

use App\Tasks\Application\Command\CreateTaskCommand;
use App\Tasks\Domain\Entity\Task;
use App\Tasks\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class CreateTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $tasksRepository;

    public function __construct(TasksRepositoryInterface $tasksRepository)
    {
        $this->tasksRepository = $tasksRepository;
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        $task = new Task($command->getId(), $command->getName());

        $this->tasksRepository->add($task);
    }
}