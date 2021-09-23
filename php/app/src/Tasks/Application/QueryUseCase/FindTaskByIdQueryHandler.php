<?php
declare(strict_types=1);

namespace App\Tasks\Application\QueryUseCase;

use App\Tasks\Application\Query\FindTaskByIdQuery;
use App\Tasks\Domain\DataProvider\TaskDataProviderInterface;
use App\Tasks\Domain\DTO\Task;
use App\Tasks\Domain\Exception\TaskNotFoundException;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindTaskByIdQueryHandler implements QueryUseCaseInterface
{
    private $tasksDataProvider;

    public function __construct(TaskDataProviderInterface $tasksDataProvider)
    {
        $this->tasksDataProvider = $tasksDataProvider;
    }

    public function __invoke(FindTaskByIdQuery $query): ?Task
    {
        try {
            return $this->tasksDataProvider->findTask($query->getId());
        } catch (TaskNotFoundException $e) {
            return null;
        }
    }
}