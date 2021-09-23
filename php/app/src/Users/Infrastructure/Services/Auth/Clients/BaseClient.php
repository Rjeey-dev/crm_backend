<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth\Clients;

class BaseClient
{
    protected function generateUserId(string $userId, string $salt, string $key): string
    {
        return sprintf('%s%s', hash_hmac('sha256', $salt, $key), $userId);
    }
}
