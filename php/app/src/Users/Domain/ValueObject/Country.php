<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument */
class Country
{
    /**
     * @MongoDB\Field(type="string")
     */
    private $code;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
