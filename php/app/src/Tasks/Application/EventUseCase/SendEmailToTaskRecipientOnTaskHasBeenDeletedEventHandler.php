<?php
declare(strict_types=1);

namespace App\Tasks\Application\EventUseCase;

use App\Core\Application\Command\SendEmail;
use App\Tasks\Domain\Event\TaskHasBeenDeletedEvent;
use App\Users\Application\Query\GetUserQuery;
use App\Users\Domain\DTO\User;
use NinjaBuggs\ServiceBus\Command\CommandBusInterface;
use NinjaBuggs\ServiceBus\Event\EventUseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;

class SendEmailToTaskRecipientOnTaskHasBeenDeletedEventHandler implements EventUseCaseInterface
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

    public function __invoke(TaskHasBeenDeletedEvent $event): void
    {
        try {
            /** @var User $user */
            $user = $this->queryBus->handle(new GetUserQuery($event->getRecipient()));

            $this->commandBus->handle(new SendEmail(
                'en',
                SendEmail::CHANNEL_TASK,
                SendEmail::TYPE_TASK_HAS_BEEN_DELETED,
                $this->email,
                [$user->getEmail()],
                SendEmail::SUBJECT_TASK_HAS_BEEN_DELETED,
                SendEmail::FORMAT_HTML,
                [
                    'name' => $event->getName(),
                    'owner_name' => $event->getOwnerName(),
                ]
            ));
        } catch (\Throwable $e) {
            // suppress exceptions
        }
    }
}
