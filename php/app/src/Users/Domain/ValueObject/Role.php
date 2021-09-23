<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument */
class Role
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    public const supportedRoles = [
        self::ROLE_ADMIN,
        self::ROLE_USER
    ];

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $updated;

    public function __construct(string $name, ?\DateTimeImmutable $updated = null)
    {
        $this->validateRole($name);

        $this->name = $name;
        $this->updated = $updated ?? new \DateTimeImmutable();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function validateRole(string $name): void
    {
        if (!in_array($name, self::supportedRoles, true)) {
            throw new \InvalidArgumentException('unsupported_role');
        }
    }
}
