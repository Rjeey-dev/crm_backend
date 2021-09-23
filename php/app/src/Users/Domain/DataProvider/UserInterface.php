<?php
declare(strict_types=1);

namespace App\Users\Domain\DataProvider;

use App\Users\Domain\DTO\User;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\ValueObject\UserId;
use App\Users\Domain\ValueObject\UserLogin;

interface UserInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function getUser(UserId $id, ?UserId $currentUserId = null): User;

    public function userExistsByLogin(UserLogin $login): bool;
}