<?php
declare(strict_types=1);

namespace App\Comments\Application\Query;

use App\Comments\Domain\ValueObject\CommentId;
use NinjaBuggs\ServiceBus\Query\QueryInterface;

class FindCommentByIdQuery implements QueryInterface
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