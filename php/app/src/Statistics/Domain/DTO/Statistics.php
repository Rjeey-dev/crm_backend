<?php
declare(strict_types=1);

namespace App\Statistics\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Statistics
{
    /**
     * @Serializer\SerializedName("my_tasks")
     * @Serializer\Type("array")
     * @Serializer\Groups({
     *     "statistics-detail",
     * })
     */
    public $myTasks;

    /**
     * @Serializer\SerializedName("created_tasks")
     * @Serializer\Type("array")
     * @Serializer\Groups({
     *     "statistics-detail",
     * })
     */
    public $createdTasks;

    public function __construct(array $myTasks, array $createdTasks)
    {
        $this->myTasks = $myTasks;
        $this->createdTasks = $createdTasks;
    }
}
