<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Identity;

use Hashids\Hashids;

class SequenceBase64Id extends SequenceId
{
    private const SALT = 'travel_forever';

    public static function generate(): SequenceId
    {
        $hashIds = new Hashids(self::SALT, 8, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");

        return new static($hashIds->encode(SequenceIdGenerator::generate()));
    }
}
