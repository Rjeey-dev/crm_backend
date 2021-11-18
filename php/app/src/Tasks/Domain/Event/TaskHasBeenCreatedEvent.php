<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class TaskHasBeenCreatedEvent implements EventInterface
{
    private $id;
    private $name;
    private $recipient;
    private $owner;
    private $startDate;
    private $status;
    private $created;

    public function __construct(
        string $id,
        string $name,
        string $recipient,
        string $owner,
        \DateTimeImmutable $startDate,
        int $status,
        \DateTimeImmutable $created
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->recipient = $recipient;
        $this->owner = $owner;
        $this->status = $status;
        $this->startDate = $startDate;
        $this->created = $created;
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

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }
}