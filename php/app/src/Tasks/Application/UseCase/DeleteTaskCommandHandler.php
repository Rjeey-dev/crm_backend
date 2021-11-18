<?php
declare(strict_types=1);

namespace App\Tasks\Application\UseCase;

use App\Tasks\Application\Command\DeleteTaskCommand;
use App\Tasks\Domain\DataProvider\TaskDataProviderInterface;
use App\Tasks\Domain\DTO\Task;
use App\Tasks\Domain\Repository\TasksRepositoryInterface;
use App\Users\Application\Query\GetCurrentUserQuery;
use App\Users\Domain\Exception\ForbiddenException;
use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class DeleteTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $tasksRepository;
    private $tasksDataProvider;
    private $queryBus;

    public function __construct(
        TasksRepositoryInterface $tasksRepository,
        QueryBusInterface $queryBus,
        TaskDataProviderInterface $tasksDataProvider
    ) {
        $this->tasksRepository = $tasksRepository;
        $this->queryBus = $queryBus;
        $this->tasksDataProvider = $tasksDataProvider;
    }

    public function __invoke(DeleteTaskCommand $command): void
    {
        /** @var UserId $currentUser */
        $currentUser = $this->queryBus->handle(new GetCurrentUserQuery());

        /** @var Task $taskDTO */
        $taskDTO = $this->tasksDataProvider->findTask($command->getId());

        if (!$currentUser->isEqual($taskDTO->owner->getId())) {
            throw new ForbiddenException();
        }

        $task = $this->tasksRepository->get($command->getId());

        $task->delete();

        $this->tasksRepository->remove($task);
    }
}