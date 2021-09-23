<?php
declare(strict_types=1);

namespace App\Tasks\Application\Query;

use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Query\QueryInterface;

class FindTaskByIdQuery implements QueryInterface
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = new TaskId($id);
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}