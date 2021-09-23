<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Repository;

use App\Tasks\Domain\Entity\Task;
use App\Tasks\Domain\Exception\TaskNotFoundException;
use App\Tasks\Domain\ValueObject\TaskId;

interface TasksRepositoryInterface
{
    /**
     * @throws TaskNotFoundException
     */
    public function get(TaskId $id): Task;
    public function add(Task $task): void;
    public function remove(Task $task): void;
}