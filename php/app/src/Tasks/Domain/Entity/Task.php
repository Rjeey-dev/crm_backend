<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Entity;

use App\Tasks\Domain\Event\TaskHasBeenCreatedEvent;
use App\Tasks\Domain\Event\TaskHasBeenUpdateEvent;
use App\Tasks\Domain\Event\TaskHasBeenDeletedEvent;
use App\Tasks\Domain\ValueObject\TaskId;
use App\Tasks\Domain\ValueObject\User;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class Task implements EventRecordableInterface
{
    use EventRecordableTrait;

    public const STATUS_TODO = 0;
    public const STATUS_DOING = 1;
    public const STATUS_DONE = 2;

    /**
     * @MongoDB\Id(strategy="NONE", type="task:task_id")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $text;

    /**
     * @MongoDB\Field(type="int")
     */
    private $status = self::STATUS_TODO;

    /** @MongoDB\EmbedOne(targetDocument="\App\Tasks\Domain\ValueObject\User") */
    private $recipient;

    /** @MongoDB\EmbedOne(targetDocument="\App\Tasks\Domain\ValueObject\User") */
    private $owner;

    /**
     * @MongoDB\Field(name="start_date", type="date_immutable")
     */
    private $startDate;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(
        TaskId $id,
        string $name,
        string $text,
        User $recipient,
        User $owner,
        \DateTimeImmutable $startDate
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->recipient = $recipient;
        $this->owner = $owner;
        $this->startDate = $startDate;
        $this->text = $text;

        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new TaskHasBeenCreatedEvent(
            $id->getId(),
            $name,
            $recipient->getId(),
            $owner->getId(),
            $startDate,
            $this->status,
            $this->created
        ));
    }

    public function update(?string $name, ?string $text, ?int $status): void
    {
        if (!$name && !$text && !$status) {
            return;
        }

        $idEdit = $name !== $this->name || $text !== $this->text;
        $this->name = $name ?? $this->name;
        $this->text = $text ?? $this->text;
        $this->status = $status ?? $this->status;

        $this->recordEvent(new TaskHasBeenUpdateEvent(
            $this->id->getId(),
            $this->name,
            $this->text,
            $this->status,
            $this->recipient->getId(),
            $this->recipient->getName(),
            $this->owner->getId(),
            ($this->status === self::STATUS_DOING && $status !== $this->status),
            ($this->status === self::STATUS_DONE && $status !== $this->status),
            $idEdit
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new TaskHasBeenDeletedEvent(
            $this->id->getId(),
            $this->name,
            $this->status,
            $this->recipient->getId(),
            $this->owner->getId(),
            $this->owner->getName()
        ));
    }

    public function start(): void
    {
        if ($this->status !== self::STATUS_TODO) {
            throw new \LogicException();
        }

        $this->status = self::STATUS_DOING;

        $this->recordEvent(new TaskHasBeenUpdateEvent(
            $this->id->getId(),
            $this->name,
            $this->status,
            $this->recipient->getId(),
            $this->recipient->getName(),
            $this->owner->getId(),
            true,
            false
        ));
    }
}
