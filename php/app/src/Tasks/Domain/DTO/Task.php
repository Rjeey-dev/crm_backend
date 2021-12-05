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
     * @Serializer\SerializedName("text")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $text;

    /**
     * @Serializer\SerializedName("recipient")
     * @Serializer\Type("App\Tasks\Domain\DTO\User")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $recipient;

    /**
     * @Serializer\SerializedName("owner")
     * @Serializer\Type("App\Tasks\Domain\DTO\User")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $owner;

    /**
     * @Serializer\SerializedName("start_date")
     * @Serializer\Type("DateTimeImmutable")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $startDate;

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

    public function __construct(
        string $id,
        string $name,
        string $text,
        User $recipient,
        User $owner,
        \DateTimeImmutable $startDate,
        int $status,
        \DateTimeImmutable $created
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->text = $text;
        $this->recipient = $recipient;
        $this->owner = $owner;
        $this->startDate = $startDate;
        $this->status = $status;
        $this->created = $created;
    }
}