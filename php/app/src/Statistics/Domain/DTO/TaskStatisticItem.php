<?php

declare(strict_types=1);

namespace App\Statistics\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class TaskStatisticItem
{
    /**
     * @Serializer\SerializedName("status")
     * @Serializer\Type("int")
     * @Serializer\Groups({
     *     "statistics-detail",
     * })
     */
    public int $status;

    /**
     * @Serializer\SerializedName("number")
     * @Serializer\Type("int")
     * @Serializer\Groups({
     *     "statistics-detail",
     * })
     */
    public int $number;

    public function __construct(int $status, int $number)
    {
        $this->status = $status;
        $this->number = $number;
    }
}
