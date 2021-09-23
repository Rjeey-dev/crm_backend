<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth\DTO;

class User
{
    public $id;
    public $login;
    public $name;
    public $email;
    public $picture;
    public $instagram;
    public $vk;
    public $socialSource;

    public function __construct(
        string $id,
        string $login,
        string $socialSource,
        ?string $name = null,
        ?string $email = null,
        ?string $picture = null,
        ?string $instagram = null,
        ?string $vk = null
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->name = $name;
        $this->email = $email;
        $this->picture = $picture;
        $this->instagram = $instagram;
        $this->vk = $vk;
        $this->socialSource = $socialSource;
    }
}