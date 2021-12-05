<?php
declare(strict_types=1);

namespace App\Statistics\Application\Query;

use NinjaBuggs\ServiceBus\Query\QueryInterface;

class FindStatisticsQuery implements QueryInterface
{
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}