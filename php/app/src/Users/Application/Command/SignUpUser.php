<?php
declare(strict_types=1);

namespace App\Users\Application\Command;

use App\Users\Domain\ValueObject\UserId;
use App\Users\Domain\ValueObject\UserLogin;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class SignUpUser implements CommandInterface
{
    private $id;
    private $name;
    private $login;
    private $image;
    private $email;
    private $lang;

    public function __construct(
        string $id,
        string $login,
        string $lang,
        ?string $image,
        ?string $email = null,
        ?string $name = null
    ) {
        $this->id = new UserId($id);
        $this->name = $name ?? $login;
        $this->login = new UserLogin($login);
        $this->image = $image;
        $this->email = $email;
        $this->lang = $lang;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLogin(): UserLogin
    {
        return $this->login;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
