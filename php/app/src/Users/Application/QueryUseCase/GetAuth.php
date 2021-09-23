<?php
declare(strict_types=1);

namespace App\Users\Application\QueryUseCase;

use App\Users\Application\Query\GetAuth as GetAuthQuery;
use App\Users\Infrastructure\Services\Auth\DTO\Auth;
use App\Users\Infrastructure\Services\Auth\TokenGenerator;
use App\Users\Infrastructure\Services\Auth\UserProviderInterface;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class GetAuth implements QueryUseCaseInterface
{
    private $authProvider;
    private $tokenGenerator;

    public function __construct(UserProviderInterface $authProvider, TokenGenerator $tokenGenerator)
    {
        $this->authProvider = $authProvider;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(GetAuthQuery $query): Auth
    {
        $user = $this->authProvider->getUser($query->getPlatform(), $query->getParams());

        return new Auth($user, $this->tokenGenerator->generate($user->id));
    }
}
