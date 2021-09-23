<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine\ODM\Repository;

use App\Kernel\Doctrine\DocumentRepository;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Entity\User as UserEntity;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\ValueObject\UserId;

class User extends DocumentRepository implements UserRepositoryInterface
{
    public function get(UserId $id): UserEntity
    {
        $user = $this->getDocumentManager()->find(UserEntity::class, $id->getId());

        if (!$user) {
            throw new UserNotFoundException(sprintf('User with id - %s is not found', $id->getId()));
        }

        return $user;
    }

    public function add(UserEntity $user): void
    {
        $this->getDocumentManager()->persist($user);
    }

    public function delete(UserEntity $user): void
    {
        $this->getDocumentManager()->remove($user);
    }
}