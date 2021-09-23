<?php
declare(strict_types=1);

namespace App\Tasks\Domain\DataProvider;

use App\Tasks\Domain\DTO\Task;
use App\Tasks\Domain\DTO\TasksList;
use App\Tasks\Domain\Exception\TaskNotFoundException;
use App\Tasks\Domain\ValueObject\TaskId;

interface TaskDataProviderInterface
{
    /**
     * @throws TaskNotFoundException
     */
    public function findTask(TaskId $id): Task;
    public function findTasks(int $offset, int $limit, string $order): TasksList;
}