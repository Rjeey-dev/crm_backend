<?php
declare(strict_types=1);

namespace App\Users\Domain\DataProvider;

use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\ValueObject\UserId;

interface AuthInterface
{
    public function set(UserId $id, string $token): void;

    /**
     * @throws UserNotFoundException
     */
    public function get(string $token);
    public function delete(string $token);
    public function deleteAll();
}
