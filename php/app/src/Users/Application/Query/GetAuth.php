<?php
declare(strict_types=1);

namespace App\Users\Application\Query;

use NinjaBuggs\ServiceBus\Query\QueryInterface;

class GetAuth implements QueryInterface
{
    private $platform;
    private $params;

    public function __construct(string $platform, array $params)
    {
        $this->platform = $platform;
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }
}
