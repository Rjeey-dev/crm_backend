<?php
declare(strict_types=1);

namespace App\Core\Application\Command;

use NinjaBuggs\ServiceBus\Command\CommandInterface;

class SendEmail implements CommandInterface
{
    public const SUBJECT_NEW_TASK_CREATED = 'new_task_created';
    public const SUBJECT_TASK_HAS_BEEN_STARTED = 'task_has_been_started';
    public const SUBJECT_TASK_HAS_BEEN_COMPLETED = 'task_has_been_completed';
    public const SUBJECT_TASK_HAS_BEEN_DELETED = 'task_has_been_deleted';

    public const FORMAT_TEXT = 'txt';
    public const FORMAT_HTML = 'html';

    public const CHANNEL_TASK = 'task';

    public const TYPE_NEW_TASK_CREATED = 'new_task_created';
    public const TYPE_TASK_HAS_BEEN_STARTED = 'task_has_been_started';
    public const TYPE_TASK_HAS_BEEN_COMPLETED = 'task_has_been_completed';
    public const TYPE_TASK_HAS_BEEN_DELETED = 'task_has_been_deleted';

    private const supportedFormats = [
        self::FORMAT_TEXT,
        self::FORMAT_HTML,
    ];

    private $locale;
    private $channel;
    private $type;
    private $sender;
    private $content;
    private $recipients;
    private $subject;
    private $format;
    private $attachments;
    private $parameters;

    public function __construct(
        string $locale,
        string $channel,
        string $type,
        string $sender,
        array $recipients,
        string $subject,
        string $format,
        ?array $parameters = [],
        ?string $content = null,
        ?array $attachments = null
    ) {
        $this->validateFormat($format);

        $this->locale = $locale;
        $this->channel = $channel;
        $this->type = $type;
        $this->sender = $sender;
        $this->recipients = $recipients;
        $this->subject = $subject;
        $this->parameters = $parameters;
        $this->content[$format] = $content;
        $this->format = $format;
        $this->attachments = $attachments;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    public function getContent(string $format): ?string
    {
        $this->validateFormat($format);

        if (!array_key_exists($format, $this->content)) {
            return null;
        }

        return $this->content[$format];
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    private function validateFormat(string $format): void
    {
        if (!in_array($format, self::supportedFormats, true)) {
            throw new \InvalidArgumentException('unsupported format');
        }
    }

    public function getParameters(): ?array
    {
        return $this->parameters;
    }
}