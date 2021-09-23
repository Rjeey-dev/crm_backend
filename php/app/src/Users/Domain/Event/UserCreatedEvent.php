<?php
declare(strict_types=1);

namespace App\Users\Domain\Event;

use App\Users\Domain\ValueObject\Role;
use NinjaBuggs\ServiceBus\Event\EventInterface;

class UserCreatedEvent implements EventInterface
{
    private $id;
    private $name;
    private $login;
    private $role;
    private $created;
    private $newImage;
    private $email;

    public function __construct(
        string $id,
        string $name,
        string $login,
        Role $role,
        \DateTimeImmutable $created,
        ?string $newImage,
        ?string $email = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->role = $role;
        $this->created = $created;
        $this->newImage = $newImage;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function getNewImage(): ?string
    {
        return $this->newImage;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
