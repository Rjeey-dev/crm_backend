<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine\ODM\Types;

use App\Users\Domain\ValueObject\UserId;
use Doctrine\ODM\MongoDB\Types\Type;

class UserIdType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value)
    {
        return $value === null ? null : new UserId((string) $value);
    }

    public function closureToPHP(): string
    {
        return '$return = new \App\Users\Domain\ValueObject\UserId((string) $value);';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value)
    {
        if ($value === null || !$value instanceof UserId) {
            return $value;
        }

        return $value->getId();
    }
}
