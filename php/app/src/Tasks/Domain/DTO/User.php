<?php
declare(strict_types=1);

namespace App\Tasks\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class User
{
    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    private $id;

    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    private $name;

    /**
     * @Serializer\SerializedName("login")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    private $login;

    /**
     * @Serializer\SerializedName("image")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *    "tasks-list",
     *    "task-detail",
     * })
     */
    private $image;

    public function __construct(
        string $id,
        string $login,
        string $name,
        string $image
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->login = $login;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
