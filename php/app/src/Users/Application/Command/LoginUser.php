<?php
declare(strict_types=1);

namespace App\Users\Application\Command;

use App\Users\Domain\ValueObject\UserId;
use App\Users\Domain\ValueObject\UserLogin;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class LoginUser implements CommandInterface
{
    private $id;
    private $login;
    private $lang;

    public function __construct(string $id, string $login, ?string $lang = null)
    {
        $this->id = new UserId($id);
        $this->login = new UserLogin($login);
        $this->lang = $lang;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getLogin(): UserLogin
    {
        return $this->login;
    }
}