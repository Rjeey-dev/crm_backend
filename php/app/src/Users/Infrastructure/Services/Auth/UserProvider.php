<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth;

use App\Users\Infrastructure\Services\Auth\DTO\User;

class UserProvider implements UserProviderInterface
{
    private $clientFactory;

    public function __construct(AuthClientFactoryInterface $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }


    public function getUser(string $platform, array $params): User
    {
        $client = $this->clientFactory->getAuthClient($platform);

        return $client->auth($params);
    }
}
