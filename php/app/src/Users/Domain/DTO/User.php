<?php
declare(strict_types=1);

namespace App\Users\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
 */
class User
{
    private $id;
    private $name;
    private $login;
    private $email;
    private $image;
    private $settings;
    private $role;
    private $created;

    public function __construct(
        string $id,
        string $name,
        string $login,
        Role $role,
        ?Settings $settings,
        ?string $email,
        ?string $image,
        \DateTimeImmutable $created
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->image = $image;
        $this->settings = $settings;
        $this->role = $role;
        $this->created = $created;
    }

    /**
     * @Expose
     * @Serializer\SerializedName("id")
     * @Serializer\VirtualProperty
     * @Serializer\Type("string")
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @Expose
     * @Serializer\SerializedName("name")
     * @Serializer\VirtualProperty
     * @Serializer\Type("string")
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @Expose
     * @Serializer\SerializedName("login")
     * @Serializer\VirtualProperty
     * @Serializer\Type("string")
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @Expose
     * @Serializer\SerializedName("email")
     * @Serializer\VirtualProperty
     * @Serializer\Type("string")
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @Expose
     * @Serializer\SerializedName("image")
     * @Serializer\VirtualProperty
     * @Serializer\Type("string")
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @Expose
     * @Serializer\SerializedName("settings")
     * @Serializer\VirtualProperty
     * @Serializer\Type("App\Users\Domain\DTO\Settings")
     */
    public function getSettings(): ?Settings
    {
        return $this->settings;
    }

    public function getLang(): ?string
    {
        if (!$this->settings) {
            return null;
        }

        return $this->settings->getLang();
    }

    /**
     * @Expose
     * @Serializer\SerializedName("role")
     * @Serializer\VirtualProperty
     * @Serializer\Type("App\Users\Domain\DTO\Role")
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    public function getRoleName(): string
    {
        return $this->role->getName();
    }

    /**
     * @Expose
     * @Serializer\SerializedName("date")
     * @Serializer\VirtualProperty
     * @Serializer\Type("DateTimeImmutable")
     */
    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function isUserEmailVerified(): bool
    {
        return $this->context->isUserEmailVerified();
    }
}
