<?php
declare(strict_types=1);

namespace App\Users\Application\QueryUseCase;

use App\Users\Application\Query\GetCurrentUserQuery;
use App\Users\Application\Query\GetUserQuery;
use App\Users\Domain\DataProvider\UserInterface;
use App\Users\Domain\DTO\User;
use App\Users\Domain\Exception\UnauthorizedException;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class GetUserHandler implements QueryUseCaseInterface
{
    private $userDataProvider;
    private $queryBus;

    public function __construct(UserInterface $userDataProvider, QueryBusInterface $queryBus)
    {
        $this->userDataProvider = $userDataProvider;
        $this->queryBus = $queryBus;
    }

    public function __invoke(GetUserQuery $query): User
    {
        return $this->userDataProvider->getUser($query->getId(), $query->getCurrentId() ?? $this->getCurrentUser());
    }

    private function getCurrentUser(): ?UserId
    {
        try {
            /** @var UserId $currenUser */
            return $this->queryBus->handle(new GetCurrentUserQuery());
        } catch (UserNotFoundException | UnauthorizedException $e) {
            return null;
        }
    }
}