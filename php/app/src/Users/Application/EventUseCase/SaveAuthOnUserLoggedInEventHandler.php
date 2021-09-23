<?php
declare(strict_types=1);

namespace App\Users\Application\EventUseCase;

use App\Users\Domain\Event\UserLoggedInEvent;
use App\Users\Domain\Services\AuthInterface;
use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Event\EventUseCaseInterface;

class SaveAuthOnUserLoggedInEventHandler implements EventUseCaseInterface
{
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(UserLoggedInEvent $event): void
    {
        $this->auth->authorizeUser(new UserId($event->getId()));
    }
}