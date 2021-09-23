<?php
declare(strict_types=1);

namespace App\Users\Application\QueryUseCase;

use App\Users\Application\Query\GetCurrentUserDetailsQuery;
use App\Users\Application\Query\GetCurrentUserQuery;
use App\Users\Domain\DataProvider\UserInterface;
use App\Users\Domain\DTO\User;
use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class GetCurrentUserDetailsQueryHandler implements QueryUseCaseInterface
{
    private $queryBus;
    private $usersDataProvider;

    public function __construct(QueryBusInterface $queryBus, UserInterface $usersDataProvider)
    {
        $this->queryBus = $queryBus;
        $this->usersDataProvider = $usersDataProvider;
    }

    public function __invoke(GetCurrentUserDetailsQuery $query): ?User
    {
        /** @var UserId $currentUserId */
        $currentUserId = $this->queryBus->handle(new GetCurrentUserQuery());

        return $this->usersDataProvider->getUser($currentUserId, $query->isFullProfile() ? $currentUserId : null);
    }
}
