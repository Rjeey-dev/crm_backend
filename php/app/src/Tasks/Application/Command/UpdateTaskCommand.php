<?php
declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\Exception\ValidationException;
use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateTaskCommand implements CommandInterface
{
    private const STATUS_TODO = 0;
    private const STATUS_DOING = 1;
    private const STATUS_DONE = 2;

    private const SUPPORTED_STATUSES = [
        self::STATUS_TODO,
        self::STATUS_DOING,
        self::STATUS_DONE,
    ];

    private $id;
    private $name;
    private $text;
    private $status;

    /**
     * @throws ValidationException
     */
    public function __construct(string $id, ?string $name, ?string $text, ?int $status)
    {
        $this->validateStatus($status);

        $this->id = new TaskId($id);
        $this->name = $name;
        $this->text = $text;
        $this->status = $status;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @throws ValidationException
     */
    private function validateStatus(?int $status): void
    {
        if (!$status) {
            return;
        }

        if (!in_array($status, self::SUPPORTED_STATUSES, true)) {
            throw new ValidationException('Status not valid');
        }
    }
}
