<?php
declare(strict_types=1);

namespace App\Core\Application\UseCase;

use App\Core\Application\Command\CreatePushNotificationCommand;
use JMS\Serializer\SerializerInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

class CreatePushNotificationCommandHandler implements UseCaseInterface
{
    private $publisher;
    private $queryBus;
    private $serializer;

    public function __construct(
        PublisherInterface $publisher,
        QueryBusInterface $queryBus,
        SerializerInterface $serializer
    ) {
        $this->publisher = $publisher;
        $this->queryBus = $queryBus;
        $this->serializer = $serializer;
    }

    public function __invoke(CreatePushNotificationCommand $command): void
    {
        $update = new Update(
            sprintf('ws-%s', $command->getUserId()),
            $this->serializer->serialize([
                'type' => $command->getType(),
                'message' => $command->getData()
            ], 'json'),
            true,
            'ws-' . $command->getUserId()
        );

        // The Publisher service is an invokable object
        ($this->publisher)($update);
    }
}
