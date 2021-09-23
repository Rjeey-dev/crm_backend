<?php
declare(strict_types=1);

namespace App\Comments\Infrastructure\Persistence\Doctrine\ODM\Types;

use App\Comments\Domain\ValueObject\CommentId;
use Doctrine\ODM\MongoDB\Types\Type;

class CommentIdType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value)
    {
        return $value === null ? null : new CommentId((string) $value);
    }

    public function closureToPHP(): string
    {
        return '$return = new \App\Comments\Domain\ValueObject\CommentId((string) $value);';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value)
    {
        if ($value === null || !$value instanceof CommentId) {
            return $value;
        }

        return $value->getId();
    }
}