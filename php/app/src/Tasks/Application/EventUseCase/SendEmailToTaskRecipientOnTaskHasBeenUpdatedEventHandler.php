<?php
declare(strict_types=1);

namespace App\Tasks\Application\EventUseCase;

use App\Core\Application\Command\SendEmail;
use App\Tasks\Domain\Event\TaskHasBeenUpdateEvent;
use App\Users\Application\Query\GetUserQuery;
use App\Users\Domain\DTO\User;
use NinjaBuggs\ServiceBus\Command\CommandBusInterface;
use NinjaBuggs\ServiceBus\Event\EventUseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;

class SendEmailToTaskRecipientOnTaskHasBeenUpdatedEventHandler implements EventUseCaseInterface
{
    private $commandBus;
    private $email;
    private $queryBus;

    public function __construct(
        CommandBusInterface $commandBus,
        string $serviceEmail,
        QueryBusInterface $queryBus
    ) {
        $this->commandBus = $commandBus;
        $this->email = $serviceEmail;
        $this->queryBus = $queryBus;
    }

    public function __invoke(TaskHasBeenUpdateEvent $event): void
    {
        try {
            if (!$event->isEditDone()) {
                return;
            }

            /** @var User $user */
            $user = $this->queryBus->handle(new GetUserQuery($event->getRecipient()));

            $this->commandBus->handle(new SendEmail(
                'en',
                SendEmail::CHANNEL_TASK,
                SendEmail::TYPE_TASK_HAS_BEEN_UPDATED,
                $this->email,
                [$user->getEmail()],
                SendEmail::SUBJECT_TASK_HAS_BEEN_UPDATED,
                SendEmail::FORMAT_HTML,
                [
                    'name' => $event->getName(),
                    'text' => $event->getText(),
                ]
            ));
        } catch (\Throwable $e) {
            // suppress exceptions
        }
    }
}
