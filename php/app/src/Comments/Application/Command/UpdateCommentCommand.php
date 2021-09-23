<?php
declare(strict_types=1);

namespace App\Comments\Application\Command;

use App\Comments\Domain\ValueObject\CommentId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateCommentCommand implements CommandInterface
{
    private $id;
    private $comment;
    private $text;

    public function __construct(string $id, string $comment, string $text)
    {
        $this->id = new CommentId($id);
        $this->text = $text;
        $this->comment = $comment;
    }

    public function getId(): CommentId
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