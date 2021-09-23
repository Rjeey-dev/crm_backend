<?php
declare(strict_types=1);

namespace App\Users\Domain\Repository;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\ValueObject\UserId;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function get(UserId $id): User;

    public function add(User $user): void;

    public function delete(User $user): void;
}
