<?php
declare(strict_types=1);

namespace App\Users\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class UserStateHasBeenChangedEvent implements EventInterface
{
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
