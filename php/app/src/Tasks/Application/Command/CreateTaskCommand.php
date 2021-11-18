<?php
declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateTaskCommand implements CommandInterface
{
    private $id;
    private $name;
    private $recipient;
    private $startDate;

    public function __construct(string $name, string $recipient, \DateTimeImmutable $startDate)
    {
        $this->id = TaskId::generate();
        $this->name= $name;
        $this->recipient = $recipient;
        $this->startDate = $startDate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }
}