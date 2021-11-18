<?php
declare(strict_types=1);

namespace App\Tasks\Application\QueryUseCase;

use App\Tasks\Application\Query\FindTasksQuery;
use App\Tasks\Domain\DataProvider\TaskDataProviderInterface;
use App\Tasks\Domain\DTO\TasksList;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindTasksQueryHandler implements QueryUseCaseInterface
{
    private $tasksDataProvider;

    public function __construct(TaskDataProviderInterface $tasksDataProvider, QueryBusInterface $queryBus)
    {
        $this->tasksDataProvider = $tasksDataProvider;
    }

    public function __invoke(FindTasksQuery $query): TasksList
    {
        return $this->tasksDataProvider->findTasks(
            $query->getOffset(),
            $query->getLimit(),
            $query->getOrder()
        );
    }
}