<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth\Clients;

use App\Users\Infrastructure\Services\Auth\DTO\User;
use App\Users\Infrastructure\Services\Auth\Exception\AuthException;

interface ClientInterface
{
    /**
     * @throws AuthException
     */
    public function auth(array $params): User;
}
