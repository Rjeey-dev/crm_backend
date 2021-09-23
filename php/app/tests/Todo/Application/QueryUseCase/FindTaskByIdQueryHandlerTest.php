<?php
declare(strict_types=1);

namespace App\Tests\Todo\Application\QueryUseCase;

use App\Todo\Application\Query\FindTaskByIdQuery;
use App\Todo\Application\QueryUseCase\FindTaskByIdQueryHandler;
use App\Todo\Domain\DataProvider\TasksDataProviderInterface;
use App\Todo\Domain\DTO\Task;
use App\Todo\Domain\Exception\TaskNotFoundException;
use App\Todo\Domain\ValueObject\TaskId;
use PHPUnit\Framework\TestCase;

class FindTaskByIdQueryHandlerTest extends TestCase
{
    private $dataProvider;
    private $handler;

    protected function setUp(): void
    {
        $this->dataProvider = $this->createMock(TasksDataProviderInterface::class);
        $this->handler = new FindTaskByIdQueryHandler($this->dataProvider);
    }

    public function testHandlerShouldFindTaskById(): void
    {
        $id = TaskId::generate();
        $query = new FindTaskByIdQuery($id->getId());
        $expectedTask = new Task($id->getId(), 'task description', new \DateTimeImmutable());

        $this->dataProvider->expects($this->once())
            ->method('findTask')
            ->with($query->getId())
            ->willReturn($expectedTask);

        $this->assertEquals($expectedTask, ($this->handler)($query));
    }

    public function testHandlerShouldNotFindTaskById(): void
    {
        $this->dataProvider->method('findTask')
            ->willThrowException(new TaskNotFoundException());

        $this->assertNull(($this->handler)(new FindTaskByIdQuery((TaskId::generate())->getId())));
    }
}
