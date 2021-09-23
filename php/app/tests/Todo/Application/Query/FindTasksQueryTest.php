<?php
declare(strict_types=1);

namespace App\Tests\Todo\Application\Query;

use App\Todo\Application\Query\FindTasksQuery;
use App\Todo\Domain\Exception\ValidationException;
use PHPUnit\Framework\TestCase;

class FindTasksQueryTest extends TestCase
{
    /**
     * @testWith [0, 20, "DESC", 0, 20, "DESC"]
     *           [null, null, null, 0, 20, "ASC"]
     */
    public function testConstructor(
        ?int $offset,
        ?int $limit,
        ?string $order,
        int $expectedOffset,
        int $expectedLimit,
        string $expectedOrder
    ): void {
        $query = new FindTasksQuery($offset, $limit, $order);

        $this->assertEquals($expectedOffset, $query->getOffset());
        $this->assertEquals($expectedLimit, $query->getLimit());
        $this->assertEquals($expectedOrder, $query->getOrder());
    }

    /**
     * @dataProvider provideSearchData
     */
    public function testConstructorWithOffsetValidationException(
        int $offset,
        int $limit,
        string $order,
        string $expectedExceptionMessage
    ): void {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        new FindTasksQuery($offset, $limit, $order);
    }

    public function provideSearchData(): array
    {
        return [
            // offset, limit, order, exception message
            [-1, 20, 'DESC', 'Offset should be positive'],
            [0, -1, 'DESC', 'Limit should be positive'],
            [0, 50, 'DESC', 'Limit should not be more than 40'],
            [0, 20, 'wrong', 'Order should be ASC or DESC'],
        ];
    }
}
