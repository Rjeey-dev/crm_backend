<?php
declare(strict_types=1);

namespace App\Core\Application\UseCase;

use App\Core\Application\Command\SendEmail as SendEmailCommand;
use App\Core\Infrastructure\Services\Translator\Translator;
use App\Core\Infrastructure\Services\Translator\TranslatorInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class SendEmail implements UseCaseInterface
{
    private $mailer;
    private $engine;
    private $notificationTranslator;

    public function __construct(
        MailerInterface $mailer,
        Environment $engine,
        TranslatorInterface $notificationTranslator
    ) {
        $this->mailer = $mailer;
        $this->engine = $engine;
        $this->notificationTranslator = $notificationTranslator;
    }

    public function __invoke(SendEmailCommand $command):void
    {
        if (empty($command->getRecipients())) {
            throw new \UnexpectedValueException('Recipient is not specified');
        }

        $subject = $this->notificationTranslator->translate(
            Translator::buildNotificationSubjectId($command->getSubject()),
            $command->getLocale()
        );

        $context = [
            'locale' => $command->getLocale(),
            'subject' => $subject,
            'parameters' => $command->getParameters(),
        ];

        $email = (new Email())
            ->sender(new Address($command->getSender(), 'CRM'))
            ->to(...$command->getRecipients())
            ->subject($subject)
            ->html($this->renderMessageBody($command, $context), 'text/html');

        $this->mailer->send($email);
    }

    private function renderMessageBody(SendEmailCommand $command, array $context = []): string
    {
        $content = $command->getContent(SendEmailCommand::FORMAT_HTML);

        if (empty($content)) {
            $template = $this->resolveTemplateName($command, SendEmailCommand::FORMAT_HTML);

            $content = $this->engine->render($template, $context);
        }

        $content = trim($content);

        if (empty($content)) {
            throw new \UnexpectedValueException('Empty message content');
        }

        return $content;
    }

    public function resolveTemplateName(SendEmailCommand $command, string $format): string
    {
        return sprintf(
            '@core/notifications/%s/%s/%s/message.%s.twig',
            $command->getChannel(),
            $command->getType(),
            $command->getLocale(),
            $format
        );
    }
}
