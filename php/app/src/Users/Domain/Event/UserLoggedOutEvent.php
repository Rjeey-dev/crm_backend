<?php
declare(strict_types=1);

namespace App\Users\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class UserLoggedOutEvent implements EventInterface
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
