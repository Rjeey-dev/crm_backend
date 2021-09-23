<?php
declare(strict_types=1);

namespace App\Comments\Application\Command;

use App\Comments\Domain\ValueObject\CommentId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateCommentCommand implements CommandInterface
{
    private $id;
    private $text;
    private $taskId;

    public function __construct(string $text, string $taskId)
    {
        $this->id = CommentId::generate();
        $this->text = $text;
        $this->taskId = $taskId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function getId(): CommentId
    {
        return $this->id;
    }
}