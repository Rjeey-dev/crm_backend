<?php
declare(strict_types=1);

namespace App\Users\Application\EventUseCase;

use App\Users\Domain\Event\UserCreatedEvent;
use App\Users\Domain\Services\AuthInterface;
use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Event\EventUseCaseInterface;

class SaveAuthOnUserSignUpEventHandler implements EventUseCaseInterface
{
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(UserCreatedEvent $event): void
    {
        $this->auth->authorizeUser(new UserId($event->getId()));
    }
}