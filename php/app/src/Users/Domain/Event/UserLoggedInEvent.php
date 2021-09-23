<?php
declare(strict_types=1);

namespace App\Users\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class UserLoggedInEvent implements EventInterface
{
    private $id;
    private $login;

    public function __construct(string $id, string $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
