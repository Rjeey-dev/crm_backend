<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class TaskHasBeenUpdateEvent implements EventInterface
{
    private $id;
    private $name;
    private $status;
    private $recipient;
    private $recipientName;
    private $owner;
    private $isStart;
    private $isCompletion;

    public function __construct(
        string $id,
        string $name,
        int $status,
        string $recipient,
        string $recipientName,
        string $owner,
        bool $isStart,
        bool $isCompletion
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->recipient = $recipient;
        $this->recipientName = $recipientName;
        $this->owner = $owner;
        $this->isStart = $isStart;
        $this->isCompletion =$isCompletion;
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

    public function isStart(): bool
    {
        return $this->isStart;
    }

    public function isCompletion(): bool
    {
        return $this->isCompletion;
    }

    public function getRecipientName(): string
    {
        return $this->recipientName;
    }
}