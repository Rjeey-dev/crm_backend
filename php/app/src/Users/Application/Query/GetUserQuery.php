<?php
declare(strict_types=1);

namespace App\Users\Application\Query;

use App\Users\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Query\QueryInterface;

class GetUserQuery implements QueryInterface
{
    private $id;
    private $currentId;

    public function __construct(string $id, ?string $currentId = null)
    {
        $this->id = new UserId($id);

        if ($currentId) {
            $this->currentId = new UserId($currentId);
        }
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getCurrentId(): ?UserId
    {
        return $this->currentId;
    }
}