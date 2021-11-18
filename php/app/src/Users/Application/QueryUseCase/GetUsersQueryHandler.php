<?php
declare(strict_types=1);

namespace App\Users\Application\QueryUseCase;

use App\Users\Application\Query\GetUsersQuery;
use App\Users\Domain\DataProvider\UserInterface;
use App\Users\Domain\Exception\ForbiddenException;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class GetUsersQueryHandler implements QueryUseCaseInterface
{
    private $userDataProvider;

    public function __construct(UserInterface $userDataProvider)
    {
        $this->userDataProvider = $userDataProvider;
    }

    /**
     * @throws ForbiddenException
     */
    public function __invoke(GetUsersQuery $query): array
    {
        return $this->userDataProvider->getUsers();
    }
}
