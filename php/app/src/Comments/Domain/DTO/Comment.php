<?php
declare(strict_types=1);

namespace App\Comments\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Comment
{
    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $id;

    /**
     * @Serializer\SerializedName("task_id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $taskId;

    /**
     * @Serializer\SerializedName("text")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $text;

    /**
     * @Serializer\SerializedName("created")
     * @Serializer\Type("DateTimeImmutable")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $created;

    public function __construct(string $id, string $taskId, string $text, \DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->taskId = $taskId;
        $this->text = $text;
        $this->created = $created;
    }
}