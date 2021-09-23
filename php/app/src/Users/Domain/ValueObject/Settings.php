<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument */
class Settings
{
    /**
     * @MongoDB\Field(type="string")
     */
    private $lang;

    /**
     * @MongoDB\Field(name="email_notifications", type="boolean")
     */
    private $emailNotifications;

    public function __construct(string $lang)
    {
        $this->lang = $lang;
        $this->emailNotifications = true;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function updateLang(string $lang): self
    {
        $this->lang = $lang;

        return clone $this;
    }

    public function updateEmailNotifications(bool $emailNotifications): void
    {
        $this->emailNotifications = $emailNotifications;
    }

    public function isEmailNotificationsEquals(bool $emailNotifications): bool
    {
        return $this->emailNotifications === $emailNotifications;
    }
}
