<?php
declare(strict_types=1);

namespace App\Users\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Level
{
    /**
     * @Serializer\SerializedName("level")
     * @Serializer\Type("integer")
     */
    public $level;

    /**
     * @Serializer\SerializedName("experience")
     * @Serializer\Type("integer")
     */
    public $experience;

    /**
     * @Serializer\SerializedName("experience_start")
     * @Serializer\Type("integer")
     */
    public $experienceStart;

    /**
     * @Serializer\SerializedName("experience_end")
     * @Serializer\Type("integer")
     */
    public $experienceEnd;

    public function __construct(
        int $level,
        int $experience,
        int $experienceStart,
        int $experienceEnd
    ) {
        $this->level = $level;
        $this->experience = $experience;
        $this->experienceStart = $experienceStart;
        $this->experienceEnd = $experienceEnd;
    }
}

