<?php
declare(strict_types=1);

namespace App\Tests\Todo\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Tests\Fixture\Todo\Tasks;
use App\Tests\OdmTestCase;
use App\Todo\Domain\ValueObject\TaskId;
use App\Todo\Infrastructure\Persistence\Doctrine\ODM\DataProvider\TasksDataProvider;

class TasksDataProviderTest extends OdmTestCase
{
    protected $dataProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            new Tasks(),
        ]);

        $this->dataProvider = new TasksDataProvider($this->getDocumentManager());
    }

    public function testFindTask(): void
    {
        $id = 'id-1';

        $task = $this->dataProvider->findTask(new TaskId($id));

        $this->assertEquals($id, $task->id);
        $this->assertEquals('text1', $task->text);
    }
}