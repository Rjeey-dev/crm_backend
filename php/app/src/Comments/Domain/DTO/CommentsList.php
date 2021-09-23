<?php
declare(strict_types=1);

namespace App\Comments\Domain\DTO;

class CommentsList
{
    private $comment;
    private $totalCount;

    /**
     * @param Comment[] $routes
     */
    public function __construct(array $comment, int $totalCount)
    {
        $this->comment = $comment;
        $this->totalCount = $totalCount;
    }

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comment;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}