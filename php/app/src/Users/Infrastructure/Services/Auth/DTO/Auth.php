<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth\DTO;

class Auth
{
    public $user;
    public $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}
