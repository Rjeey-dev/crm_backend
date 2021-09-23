<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

class UserId
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isEqual(string $id): bool
    {
        return $this->id === $id;
    }
}
