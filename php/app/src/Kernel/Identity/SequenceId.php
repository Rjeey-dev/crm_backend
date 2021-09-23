<?php
declare(strict_types=1);

namespace App\Kernel\Identity;

abstract class SequenceId
{
    /**
     * @var string
     */
    private $id;

    public static function generate(): self
    {
        return new static(SequenceIdGenerator::generate());
    }

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isEqual(string $id): bool
    {
        return $id === $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
