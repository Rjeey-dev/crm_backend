<?php
declare(strict_types=1);

namespace App\Statistics\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Statistics\Application\Query\FindStatisticsQuery;
use App\Statistics\Domain\DTO\Statistics;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends ApiController
{
    /**
     * @Route("/v1/statistics", name="statistics", methods={"GET"})
     */
    public function getStatistics(Request $request): Response
    {
        try {
            /** @var Statistics $statistics */
            $statistics = $this->queryBus->handle(new FindStatisticsQuery(
                $request->query->get('user_id')
            ));

            return $this->buildSerializedResponse(
                $statistics,
                ['statistics-detail']
            );
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }
}
