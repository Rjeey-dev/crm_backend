<?php
declare(strict_types=1);

namespace App\Comments\Infrastructure\Persistence\Doctrine\ODM\Repository;

use App\Kernel\Doctrine\DocumentRepository;
use App\Comments\Domain\Entity\Comment;
use App\Comments\Domain\Exception\CommentNotFoundException;
use App\Comments\Domain\Repository\CommentsRepositoryInterface;
use App\Comments\Domain\ValueObject\CommentId;

class CommentsRepository extends DocumentRepository implements CommentsRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function add(Comment $comment): void
    {
        $this->getDocumentManager()->persist($comment);
    }

    /**
     * {@inheritDoc}
     */
    public function get(CommentId $id): Comment
    {
        $comment = $this->getDocumentManager()->find(Comment::class, $id->getId());

        if (!$comment) {
            throw new CommentNotFoundException(sprintf('Comment with id - %s is not found', $id->getId()));
        }

        return $comment;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Comment $comment): void
    {
        $this->getDocumentManager()->remove($comment);
    }
}