<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class TaskHasBeenDeletedEvent implements EventInterface
{
    private $id;
    private $name;
    private $status;
    private $recipient;
    private $owner;
    private $ownerName;

    public function __construct(
        string $id,
        string $name,
        int $status,
        string $recipient,
        string $owner,
        string $ownerName
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->recipient = $recipient;
        $this->owner = $owner;
        $this->ownerName = $ownerName;
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

    public function getOwnerName(): string
    {
        return $this->ownerName;
    }
}