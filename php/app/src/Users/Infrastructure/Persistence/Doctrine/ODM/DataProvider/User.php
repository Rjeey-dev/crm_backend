<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\Users\Domain\DataProvider\UserInterface;
use App\Users\Domain\DTO\Role;
use App\Users\Domain\DTO\Settings;
use App\Users\Domain\DTO\User as UserDTO;
use App\Users\Domain\Entity\User as UserEntity;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\ValueObject\UserId;
use App\Users\Domain\ValueObject\UserLogin;
use App\Users\Domain\ValueObject\Role as RoleVO;

class User extends DocumentRepository implements UserInterface
{
    public function getUser(UserId $id, ?UserId $currentUserId = null): UserDTO
    {
        $query = $this->getDocumentManager()->createQueryBuilder(UserEntity::class)
            ->field('id')->equals($id->getId())
            ->hydrate(false);

        $query = $query->getQuery();

        if (!$user = $query->getSingleResult()) {
            throw new UserNotFoundException(sprintf('User %s not found', $id->getId()));
        }

        return $this->createUser($user, $currentUserId);
    }

    public function userExistsByLogin(UserLogin $login): bool
    {
        $query = $this->getDocumentManager()->createQueryBuilder(UserEntity::class)
            ->field('login')->equals($login)
            ->hydrate(false);

        $query = $query->getQuery();

        return $query->getSingleResult() !== null;
    }

    private function createUser(array $user, ?UserId $currentUserId = null): UserDTO
    {
        $settings = null;
        $email = null;

        if ($currentUserId && $currentUserId->isEqual($user['_id'])) {
            $settings = new Settings($user['settings']['lang'], (bool)$user['settings']['email_notifications']);

            $email = array_key_exists('email', $user) ? $user['email'] : null;
        }

        $role = new RoleVO($user['role']['name']);

        return new UserDTO(
            $user['_id'],
            $user['name'],
            $user['login'],
            new Role(
                $user['role']['name'],
                \DateTimeImmutable::createFromMutable($user['role']['updated']->toDateTime())
            ),
            $settings,
            $email,
            array_key_exists('image', $user) ? $user['image'] : null,
            \DateTimeImmutable::createFromMutable($user['created']->toDateTime())
        );
    }
}
