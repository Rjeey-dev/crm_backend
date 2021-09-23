<?php
declare(strict_types=1);

namespace App\Users\Application\UseCase;

use App\Users\Application\Command\LogOutUser as LogOutUserCommand;
use App\Users\Application\Query\GetCurrentUserQuery;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class LogOutUser implements UseCaseInterface, TransactionalHandlerInterface
{

    private $userRepository;
    private $queryBus;

    public function __construct(
        QueryBusInterface $queryBus,
        UserRepositoryInterface $userRepository
    ) {
        $this->queryBus = $queryBus;
        $this->userRepository = $userRepository;
    }

    public function __invoke(LogOutUserCommand $command): void
    {
        try {
            /** @var UserId $userId */
            $userId = $this->queryBus->handle(new GetCurrentUserQuery());

            $user = $this->userRepository->get($userId);
            $user->logOut();

            $this->userRepository->add($user);
        } catch (\Throwable $e) {
            // suppress exceptions
        }
    }
}
