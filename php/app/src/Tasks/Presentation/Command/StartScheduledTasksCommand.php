<?php
declare(strict_types=1);

namespace App\Tasks\Presentation\Command;

use App\Tasks\Application\Command\StartScheduledTaskCommand;
use App\Tasks\Domain\DataProvider\TaskDataProviderInterface;
use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartScheduledTasksCommand extends Command
{
    private $dataProvider;
    private $commandBus;

    protected static $defaultName = 'tasks:start_scheduled_tasks';
    
    public function __construct(TaskDataProviderInterface $dataProvider, CommandBusInterface $commandBus)
    {
        parent::__construct();

        $this->dataProvider = $dataProvider;
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Start scheduled tasks');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string[] $tasksIds */
        $tasksIds = $this->dataProvider->findScheduledTasks();

        foreach ($tasksIds as $tasksId) {
            $this->commandBus->handle(new StartScheduledTaskCommand(new TaskId($tasksId)));
        }

        $output->writeln('Done');
    }
}
