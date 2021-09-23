<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class TaskHasBeenCreatedEvent implements EventInterface
{
    private $id;
    private $name;
    private $status;

    public function __construct(string $id, string $name, int $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}