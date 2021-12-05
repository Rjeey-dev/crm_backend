<?php
declare(strict_types=1);

namespace App\Statistics\Application\QueryUseCase;

use App\Statistics\Application\Query\FindStatisticsQuery;
use App\Statistics\Domain\DataProvider\StatisticsDataProviderInterface;
use App\Statistics\Domain\DTO\Statistics;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindStatisticsQueryHandler implements QueryUseCaseInterface
{
    private $statisticsDataProvider;

    public function __construct(StatisticsDataProviderInterface $statisticsDataProvider)
    {
        $this->statisticsDataProvider = $statisticsDataProvider;
    }

    public function __invoke(FindStatisticsQuery $query): Statistics
    {
        return $this->statisticsDataProvider->findStatistics($query->getUserId());
    }
}