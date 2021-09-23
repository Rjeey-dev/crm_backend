<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

class UserLogin
{
    private $login;

    public function __construct(string $login)
    {
        $this->login = $login;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function hasLogin(string $login): bool
    {
        return $this->login === $login;
    }
}
