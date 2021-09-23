<?php
declare(strict_types=1);

namespace App\Comments\Domain\DataProvider;

use App\Comments\Domain\DTO\Comment;
use App\Comments\Domain\DTO\CommentsList;
use App\Comments\Domain\Exception\CommentNotFoundException;
use App\Comments\Domain\ValueObject\CommentId;

interface CommentDataProviderInterface
{
    /**
     * @throws CommentNotFoundException
     */
    public function findComment(CommentId $id): Comment;
    public function findComments(int $offset, int $limit, string $order, ?string $taskId): CommentsList;
}