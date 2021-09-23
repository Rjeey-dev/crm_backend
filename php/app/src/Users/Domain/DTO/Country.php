<?php
declare(strict_types=1);

namespace App\Users\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Country
{
    /**
     * @Serializer\SerializedName("code")
     * @Serializer\Type("string")
     */
    public $code;

    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    public $name;

    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }
}
