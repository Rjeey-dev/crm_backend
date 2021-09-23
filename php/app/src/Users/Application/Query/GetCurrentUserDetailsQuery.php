<?php
declare(strict_types=1);

namespace App\Users\Application\Query;

use NinjaBuggs\ServiceBus\Query\QueryInterface;

class GetCurrentUserDetailsQuery implements QueryInterface
{
    private $fullProfile;

    public function __construct(bool $fullProfile = false)
    {
        $this->fullProfile = $fullProfile;
    }

    public function isFullProfile(): bool
    {
        return $this->fullProfile;
    }
}
