<?php
declare(strict_types=1);

namespace App\Tasks\Domain\DTO;

class TasksList
{
    private $tasks;
    private $totalCount;

    /**
     * @param Task[] $routes
     */
    public function __construct(array $tasks, int $totalCount)
    {
        $this->tasks = $tasks;
        $this->totalCount = $totalCount;
    }

    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}