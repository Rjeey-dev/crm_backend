<?php
declare(strict_types=1);

namespace App\Statistics\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\Statistics\Domain\DataProvider\StatisticsDataProviderInterface;
use App\Statistics\Domain\DTO\Statistics;
use App\Statistics\Domain\DTO\TaskStatisticItem;
use App\Tasks\Domain\Entity\Task;

class StatisticsDataProvider extends DocumentRepository implements StatisticsDataProviderInterface
{
    public function findStatistics(string $userId): Statistics
    {
        $myTasks = [];
        $createdTasks = [];

        $query = $this->getDocumentManager()->createQueryBuilder(Task::class);
        $query->field('owner.id')->equals($userId);

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $task){
            $createdTasks[] = $task;
        }

        $query = $this->getDocumentManager()->createQueryBuilder(Task::class);
        $query->field('recipient.id')->equals($userId);

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $task){
            $myTasks[] = $task;
        }

        return new Statistics(
            $this->sortTasks($myTasks),
            $this->sortTasks($createdTasks)
        );
    }

    private function sortTasks(array $tasks): array
    {
        $todo = array_filter($tasks, function (array $task) {
            return $task['status'] === 0;
        });

        $doing = array_filter($tasks, function (array $task) {
            return $task['status'] === 1;
        });

        $done = array_filter($tasks, function (array $task) {
            return $task['status'] === 2;
        });

        return [
            new TaskStatisticItem(0, count($todo)),
            new TaskStatisticItem(1, count($doing)),
            new TaskStatisticItem(2, count($done)),
        ];
    }
}