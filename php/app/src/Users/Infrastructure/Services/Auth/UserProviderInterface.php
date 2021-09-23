<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth;

use App\Users\Infrastructure\Services\Auth\DTO\User;

interface UserProviderInterface
{
    public function getUser(string $platform, array $params): User;
}
