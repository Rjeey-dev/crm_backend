<?php
declare(strict_types=1);

namespace App\Tests\Fixture\Todo;

use App\Todo\Domain\Entity\Task;
use App\Todo\Domain\ValueObject\TaskId;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class Tasks extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createTask($manager, 'id-1', 'text1');
        $this->createTask($manager, 'id-2', 'text2');
        $this->createTask($manager, 'id-3', 'text3');

        $manager->flush();
    }

    private function createTask(ObjectManager $manager, string $id, string $text): void
    {
        $task = new Task(new TaskId($id), $text);

        $manager->persist($task);
    }
}
