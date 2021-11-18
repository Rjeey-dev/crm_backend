<?php
declare(strict_types=1);

namespace App\Tasks\Application\UseCase;

use App\Tasks\Application\Command\CreateTaskCommand;
use App\Tasks\Domain\Entity\Task;
use App\Tasks\Domain\Repository\TasksRepositoryInterface;
use App\Tasks\Domain\ValueObject\User;
use App\Users\Application\Query\GetCurrentUserDetailsQuery;
use App\Users\Application\Query\GetUserQuery;
use App\Users\Domain\DTO\User as UserDTO;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class CreateTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $tasksRepository;
    private $queryBus;

    public function __construct(TasksRepositoryInterface $tasksRepository, QueryBusInterface $queryBus)
    {
        $this->tasksRepository = $tasksRepository;
        $this->queryBus = $queryBus;
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        /** @var UserDTO $currentUser */
        $currentUser = $this->queryBus->handle(new GetCurrentUserDetailsQuery());
        /** @var UserDTO $recipient */
        $recipient = $this->queryBus->handle(new GetUserQuery($command->getRecipient()));

        $task = new Task(
            $command->getId(),
            $command->getName(),
            new User(
                $recipient->getId(),
                $recipient->getLogin(),
                $recipient->getName(),
                $recipient->getImage(),
                $recipient->getEmail()
            ),
            new User(
                $currentUser->getId(),
                $currentUser->getLogin(),
                $currentUser->getName(),
                $currentUser->getImage(),
                $currentUser->getEmail()
            ),
            $command->getStartDate()
        );

        $this->tasksRepository->add($task);
    }
}