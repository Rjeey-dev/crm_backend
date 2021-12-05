<?php
declare(strict_types=1);

namespace App\Statistics\Domain\DataProvider;

use App\Statistics\Domain\DTO\Statistics;

interface StatisticsDataProviderInterface
{
    public function findStatistics(string $userId): Statistics;
}
