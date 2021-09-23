<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine\ODM\Types;

use App\Users\Domain\ValueObject\UserLogin;
use Doctrine\ODM\MongoDB\Types\Type;

class UserLoginType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value)
    {
        return $value === null ? null : new UserLogin((string) $value);
    }

    public function closureToPHP(): string
    {
        return '$return = new \App\Users\Domain\ValueObject\UserLogin((string) $value);';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value)
    {
        if ($value === null || !$value instanceof UserLogin) {
            return $value;
        }

        return $value->getLogin();
    }
}
