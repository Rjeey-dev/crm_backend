<?php
declare(strict_types=1);

namespace App\Comments\Application\QueryUseCase;

use App\Comments\Application\Query\FindCommentsQuery;
use App\Comments\Domain\DataProvider\CommentDataProviderInterface;
use App\Comments\Domain\DTO\CommentsList;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindCommentsQueryHandler implements QueryUseCaseInterface
{
    private $commentsDataProvider;

    public function __construct(CommentDataProviderInterface $commentsDataProvider)
    {
        $this->commentsDataProvider = $commentsDataProvider;
    }

    public function __invoke(FindCommentsQuery $query): CommentsList
    {
        return $this->commentsDataProvider->findComments($query->getOffset(), $query->getLimit(), $query->getOrder(), $query->getTaskId());
    }
}