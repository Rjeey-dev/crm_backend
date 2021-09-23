<?php
declare(strict_types=1);

namespace App\Comments\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\Comments\Domain\DataProvider\CommentDataProviderInterface;
use App\Comments\Domain\DTO\Comment;
use App\Comments\Domain\DTO\CommentsList;
use App\Comments\Domain\Entity\Comment as  CommentEntity;
use App\Comments\Domain\Exception\CommentNotFoundException;
use App\Comments\Domain\ValueObject\CommentId;

class CommentDataProvider extends DocumentRepository implements CommentDataProviderInterface
{
    public function findComment(CommentId $id): Comment
    {
        $query = $this->getDocumentManager()->createQueryBuilder(CommentEntity::class)
            ->field('id')->equals($id->getId())
            ->hydrate(false)
            ->getQuery();

        if (!$comment = $query->getSingleResult()) {
            throw new CommentNotFoundException(sprintf('Comment %s not found', $id->getId()));
        }

        return $this->createComment($comment);
    }

    public function findComments(int $offset, int $limit, string $order, ?string $taskId): CommentsList
    {
        $commentsResult =[];

        $query = $this->getDocumentManager()->createQueryBuilder(CommentEntity::class);
        $query->skip($offset);
        $query->limit($limit);
        $query->sort('created', $order);

        if ($taskId) {
            $query->field('task_id')->equals($taskId);
        }

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $comment){
            $commentsResult[] = $this->createComment($comment);
        }

        return new CommentsList($commentsResult, count($commentsResult));
    }

    private function createComment(array $comment): Comment
    {
        return new Comment(
            $comment['_id'],
            $comment['task_id'],
            $comment['text'],
            \DateTimeImmutable::createFromMutable($comment['created']->toDateTime()),
        );
    }
}