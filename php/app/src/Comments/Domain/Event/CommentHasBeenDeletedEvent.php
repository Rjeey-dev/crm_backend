<?php
declare(strict_types=1);

namespace App\Comments\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class CommentHasBeenDeletedEvent implements EventInterface
{
    private $id;
    private $comment;
    private $text;

    public function __construct(string $id, string $comment, string $text)
    {
        $this->id = $id;
        $this->comment = $comment;
        $this->text = $text;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getText(): string
    {
        return $this->text;
    }
}