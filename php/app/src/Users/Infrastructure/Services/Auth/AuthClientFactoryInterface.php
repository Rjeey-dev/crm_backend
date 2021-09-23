<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth;

use App\Users\Infrastructure\Services\Auth\Clients\ClientInterface;

interface AuthClientFactoryInterface
{
    public function getAuthClient(string $platform): ClientInterface;
}
