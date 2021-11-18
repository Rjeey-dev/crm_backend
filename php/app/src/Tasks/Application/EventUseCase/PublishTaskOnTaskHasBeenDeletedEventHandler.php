<?php
declare(strict_types=1);

namespace App\Tasks\Application\EventUseCase;

use App\Core\Application\Command\CreatePushNotificationCommand;
use App\Tasks\Application\Query\FindTaskByIdQuery;
use App\Tasks\Domain\DTO\Task;
use App\Tasks\Domain\Event\TaskHasBeenDeletedEvent;
use NinjaBuggs\ServiceBus\Command\CommandBusInterface;
use NinjaBuggs\ServiceBus\Event\EventUseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;

class PublishTaskOnTaskHasBeenDeletedEventHandler implements EventUseCaseInterface
{
    private $commandBus;
    private $queryBus;

    public function __construct(QueryBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function __invoke(TaskHasBeenDeletedEvent $event): void
    {
        /** @var Task $task */
        $task = $this->queryBus->handle(new FindTaskByIdQuery($event->getId()));

        $this->commandBus->handle(new CreatePushNotificationCommand(
            $event->getRecipient(),
            CreatePushNotificationCommand::TYPE_TASK_DELETED,
            $task
        ));

        $this->commandBus->handle(new CreatePushNotificationCommand(
            $event->getOwner(),
            CreatePushNotificationCommand::TYPE_TASK_DELETED,
            $task
        ));
    }
}
