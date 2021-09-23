<?php
declare(strict_types=1);

namespace App\Users\Application\UseCase;

use App\Users\Application\Command\SignUpUser as SignUpUserCommand;
use App\Users\Domain\DataProvider\UserInterface;
use App\Users\Domain\Entity\User;
use App\Users\Domain\ValueObject\Role as RoleValueObject;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\ValueObject\Role;
use App\Users\Domain\ValueObject\Settings;
use App\Users\Domain\ValueObject\UserLogin;
use App\Users\Infrastructure\Services\Identity\SequenceBase64Id;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class SignUpUser implements UseCaseInterface, TransactionalHandlerInterface
{
    private $userRepository;
    private $userDataProvider;
    private $queryBus;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserInterface $userDataProvider,
        QueryBusInterface $queryBus
    ) {
        $this->userRepository = $userRepository;
        $this->userDataProvider = $userDataProvider;
        $this->queryBus = $queryBus;
    }

    public function __invoke(SignUpUserCommand $command): void
    {
        $login = $this->userDataProvider->userExistsByLogin($command->getLogin()) ?
            new UserLogin(sprintf('%s.%s', $command->getLogin(), SequenceBase64Id::generate())) :
            $command->getLogin();

        $user = new User(
            $command->getId(),
            $command->getName(),
            $login,
            new Settings($command->getLang()),
            new RoleValueObject(Role::ROLE_USER),
            $command->getEmail(),
            $command->getImage()
        );

        $this->userRepository->add($user);
    }
}
