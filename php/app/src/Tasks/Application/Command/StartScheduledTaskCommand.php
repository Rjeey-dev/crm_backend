<?php

declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class StartScheduledTaskCommand implements CommandInterface
{
    private $id;

    public function __construct(TaskId $id)
    {
        $this->id = $id;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}
