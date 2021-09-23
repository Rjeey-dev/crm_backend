<?php
declare(strict_types=1);

namespace App\Comments\Domain\Entity;

use App\Comments\Domain\Event\CommentHasBeenCreatedEvent;
use App\Comments\Domain\Event\CommentHasBeenUpdateEvent;
use App\Comments\Domain\Event\CommentHasBeenDeletedEvent;
use App\Comments\Domain\ValueObject\CommentId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class Comment implements EventRecordableInterface
{
    use EventRecordableTrait;

    /**
     * @MongoDB\Id(strategy="NONE", type="comment:comment_id")
     */
    private $id;

    /**
     * @MongoDB\Field(name="task_id", type="string")
     */
    private $taskId;

    /**
     * @MongoDB\Field(type="string")
     */
    private $text;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(CommentId $id, string $text, string $taskId)
    {
        $this->id = $id;
        $this->taskId = $taskId;
        $this->text = $text;
        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new CommentHasBeenCreatedEvent(
            $id->getId(),
            $taskId,
            $text
        ));
    }

    public function update(string $text, string $taskId): void
    {
        $this->taskId = $taskId;
        $this->text = $text;

        $this->recordEvent(new CommentHasBeenUpdateEvent(
            $this->id->getId(),
            $taskId,
            $text
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new CommentHasBeenDeletedEvent(
            $this->id->getId(),
            $this->taskId,
            $this->text
        ));
    }

}