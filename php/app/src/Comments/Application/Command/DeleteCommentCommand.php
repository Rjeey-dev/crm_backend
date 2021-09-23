<?php
declare(strict_types=1);

namespace App\Comments\Application\Command;

use App\Comments\Domain\ValueObject\CommentId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class DeleteCommentCommand implements CommandInterface
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = new CommentId($id);
    }

    public function getId(): CommentId
    {
        return $this->id;
    }
}
