<?php
declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateTaskCommand implements CommandInterface
{
    private $id;
    private $name;

    public function __construct(string $name)
    {
        $this->id = TaskId::generate();
        $this->name= $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}