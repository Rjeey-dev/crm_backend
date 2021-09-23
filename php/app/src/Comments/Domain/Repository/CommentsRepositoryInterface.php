<?php
declare(strict_types=1);

namespace App\Comments\Domain\Repository;

use App\Comments\Domain\Entity\Comment;
use App\Comments\Domain\Exception\CommentNotFoundException;
use App\Comments\Domain\ValueObject\CommentId;

interface CommentsRepositoryInterface
{
    /**
     * @throws CommentNotFoundException
     */
    public function get(CommentId $id): Comment;
    public function add(Comment $comment): void;
    public function remove(Comment $comment): void;
}