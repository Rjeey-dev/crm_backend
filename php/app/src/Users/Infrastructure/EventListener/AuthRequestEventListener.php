<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\EventListener;

use App\Users\Domain\Exception\InvalidTokenException;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class AuthRequestEventListener
{
    public function __invoke(RequestEvent $event)
    {
        if (!$event->getRequest()->headers->has('X-Auth-Token')) {
            throw new InvalidTokenException('Auth token is not found');
        }
    }
}
