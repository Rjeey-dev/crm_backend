<?php
declare(strict_types=1);

namespace App\Tasks\Domain\ValueObject;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument */
class User
{
    /**
     * @MongoDB\Field(type="string")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $email;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image;

    /**
     * @MongoDB\Field(type="string")
     */
    private $login;

    public function __construct(
        string $id,
        string $login,
        string $name,
        string $image,
        string $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->login = $login;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLogin(): string
    {
        return $this->login;
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
