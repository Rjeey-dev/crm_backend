<?php
declare(strict_types=1);

namespace App\Users\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Settings
{
    private $lang;
    private $emailNotifications;

    public function __construct(string $lang, bool $emailNotifications)
    {
        $this->lang = $lang;
        $this->emailNotifications = $emailNotifications;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getEmailNotifications(): bool
    {
        return $this->emailNotifications;
    }
}