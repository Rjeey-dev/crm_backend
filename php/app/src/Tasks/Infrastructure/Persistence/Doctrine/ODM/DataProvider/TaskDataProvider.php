<?php
declare(strict_types=1);

namespace App\Tasks\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\Tasks\Domain\DataProvider\TaskDataProviderInterface;
use App\Tasks\Domain\DTO\Task;
use App\Tasks\Domain\DTO\TasksList;
use App\Tasks\Domain\DTO\User;
use App\Tasks\Domain\Entity\Task as  TaskEntity;
use App\Tasks\Domain\Exception\TaskNotFoundException;
use App\Tasks\Domain\ValueObject\TaskId;

class TaskDataProvider extends DocumentRepository implements TaskDataProviderInterface
{
    public function findTask(TaskId $id): Task
    {
        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class)
            ->field('id')->equals($id->getId())
            ->hydrate(false)
            ->getQuery();

        if (!$task = $query->getSingleResult()) {
            throw new TaskNotFoundException(sprintf('Tasks %s not found', $id->getId()));
        }

        return $this->createTask($task);
    }

    public function findTasks(int $offset, int $limit, string $order): TasksList
    {
        $tasksResult =[];

        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class);
        $query->skip($offset);
        $query->limit($limit);
        $query->sort('created', $order);

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $task){
            $tasksResult[] = $this->createTask($task);
        }

        return new TasksList($tasksResult, count($tasksResult));
    }

    public function findScheduledTasks(): array
    {
        $tasksIds =[];

        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class);
        $query->field('status')->equals(TaskEntity::STATUS_TODO);
        $query->field('start_date')->lte(new \DateTimeImmutable());

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $task){
            $tasksIds[] = $task['_id'];
        }

        return $tasksIds;
    }

    private function createTask(array $task): Task
    {
        return new Task(
            $task['_id'],
            $task['name'],
            $task['text'],
            new User(
                $task['recipient']['id'],
                $task['recipient']['login'],
                $task['recipient']['name'],
                $task['recipient']['image']
            ),
            new User(
                $task['owner']['id'],
                $task['owner']['login'],
                $task['owner']['name'],
                $task['owner']['image']
            ),
            \DateTimeImmutable::createFromMutable($task['start_date']->toDateTime()),
            (int)$task['status'],
            \DateTimeImmutable::createFromMutable($task['created']->toDateTime()),
        );
    }
}