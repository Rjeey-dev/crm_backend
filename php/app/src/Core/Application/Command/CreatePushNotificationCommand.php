<?php
declare(strict_types=1);

namespace App\Core\Application\Command;

use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreatePushNotificationCommand implements CommandInterface
{
    public const TYPE_TASK_CREATED = 'task_created';
    public const TYPE_TASK_UPDATED = 'task_updated';
    public const TYPE_TASK_DELETED = 'task_deleted';

    private const SUPPORTED_TYPES = [
        self::TYPE_TASK_CREATED,
        self::TYPE_TASK_UPDATED,
        self::TYPE_TASK_DELETED,
    ];

    private $type;
    private $userId;
    private $data;

    public function __construct(string $userId, string $type, $data)
    {
        $this->validateType($type);

        $this->userId = $userId;
        $this->data = $data;
        $this->type = $type;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function getType(): string
    {
        return $this->type;
    }

    private function validateType(string $type): void
    {
        if (!in_array($type, self::SUPPORTED_TYPES, true)) {
            throw new \InvalidArgumentException(sprintf('Type %s is unsupported', $type));
        }
    }
}
