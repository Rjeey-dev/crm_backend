<?php
declare(strict_types=1);

namespace App\Tasks\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Task
{
    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $id;

    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $name;

    /**
     * @Serializer\SerializedName("status")
     * @Serializer\Type("int")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $status;

    /**
     * @Serializer\SerializedName("created")
     * @Serializer\Type("DateTimeImmutable")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $created;

    public function __construct(string $id, string $name, int $status, \DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->created = $created;
    }
}