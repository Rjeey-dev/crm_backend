<?php
declare(strict_types=1);

namespace App\Users\Domain\Services;

use App\Users\Domain\Exception\UnauthorizedException;
use App\Users\Domain\ValueObject\UserId;

interface AuthInterface
{
    public function authorizeUser(UserId $id): void;
    public function unauthorizeCurrentUser(): void;

    /**
     * @throws UnauthorizedException
     */
    public function getCurrentUser(): UserId;
}
