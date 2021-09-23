<?php
declare(strict_types=1);

namespace App\Users\Application\QueryUseCase;

use App\Users\Application\Query\GetCurrentUserQuery;
use App\Users\Domain\Services\AuthInterface;
use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class GetCurrentUserQueryHandler implements QueryUseCaseInterface
{
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(GetCurrentUserQuery $query): ?UserId
    {
        return $this->auth->getCurrentUser();
    }
}
