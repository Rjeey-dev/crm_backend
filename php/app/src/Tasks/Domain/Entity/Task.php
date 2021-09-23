<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Entity;

use App\Tasks\Domain\Event\TaskHasBeenCreatedEvent;
use App\Tasks\Domain\Event\TaskHasBeenUpdateEvent;
use App\Tasks\Domain\Event\TaskHasBeenDeletedEvent;
use App\Tasks\Domain\ValueObject\TaskId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class Task implements EventRecordableInterface
{
    use EventRecordableTrait;

    private const STATUS_TODO = 0;
    private const STATUS_DOING = 1;
    private const STATUS_DONE = 2;

    /**
     * @MongoDB\Id(strategy="NONE", type="task:task_id")
     */
    private $id;

    /**
     * @MongoDB\Field(name="name", type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(name="status", type="int")
     */
    private $status = self::STATUS_TODO;


    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(TaskId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;

        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new TaskHasBeenCreatedEvent(
            $id->getId(),
            $name,
            $this->status
        ));
    }

    public function update(?string $name, ?int $status): void
    {
        if (!$name && !$status) {
            return;
        }

        $this->name = $name ?? $this->name;
        $this->status = $status ?? $this->status;

        $this->recordEvent(new TaskHasBeenUpdateEvent(
            $this->id->getId(),
            $this->name,
            $this->status
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new TaskHasBeenDeletedEvent(
            $this->id->getId(),
            $this->name,
            $this->status
        ));
    }
}