<?php
declare(strict_types=1);

namespace App\Users\Application\UseCase;

use App\Users\Application\Command\LoginUser as LoginUserCommand;
use App\Users\Domain\Event\UserLoggedInEvent;
use App\Users\Domain\Repository\UserRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Event\EventBusInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class LoginUser implements UseCaseInterface, TransactionalHandlerInterface
{
    private $eventBus;
    private $userRepository;

    public function __construct(EventBusInterface $eventBus, UserRepositoryInterface $userRepository)
    {
        $this->eventBus = $eventBus;
        $this->userRepository = $userRepository;
    }

    public function __invoke(LoginUserCommand $command): void
    {
        $this->eventBus->handle(new UserLoggedInEvent($command->getId()->getId(), $command->getLogin()->getLogin()));
    }
}
