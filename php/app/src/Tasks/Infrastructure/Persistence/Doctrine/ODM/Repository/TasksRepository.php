<?php
declare(strict_types=1);

namespace App\Tasks\Infrastructure\Persistence\Doctrine\ODM\Repository;

use App\Kernel\Doctrine\DocumentRepository;
use App\Tasks\Domain\Entity\Task;
use App\Tasks\Domain\Exception\TaskNotFoundException;
use App\Tasks\Domain\Repository\TasksRepositoryInterface;
use App\Tasks\Domain\ValueObject\TaskId;

class TasksRepository extends DocumentRepository implements TasksRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function add(Task $task): void
    {
        $this->getDocumentManager()->persist($task);
    }

    /**
     * {@inheritDoc}
     */
    public function get(TaskId $id): Task
    {
        $task = $this->getDocumentManager()->find(Task::class, $id->getId());

        if (!$task) {
            throw new TaskNotFoundException(sprintf('Tasks with id - %s is not found', $id->getId()));
        }

        return $task;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Task$task): void
    {
        $this->getDocumentManager()->remove($task);
    }
}