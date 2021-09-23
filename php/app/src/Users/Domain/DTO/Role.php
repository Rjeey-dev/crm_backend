<?php
declare(strict_types=1);

namespace App\Users\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Role
{
    /**
     * @var string
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\SerializedName("updated")
     * @Serializer\Type("DateTimeImmutable")
     */
    public $updated;

    public function __construct(string $name, \DateTimeImmutable $updated)
    {
        $this->name = $name;
        $this->updated = $updated;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUpdated(): \DateTimeImmutable
    {
        return $this->updated;
    }
}
