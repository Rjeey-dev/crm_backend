<?php
declare(strict_types=1);

namespace App\Kernel\Identity;

class SequenceIdGenerator
{
    private const SERVER_NUMBER = 1;
    private const FROM_BASE = 16;
    private const TO_BASE = 10;
    private const RAND_FROM = 10;
    private const RAND_TO = 99;

    public static function generate(): string
    {
        return sprintf('%d%s%d',
            self::SERVER_NUMBER,
            base_convert(uniqid(), self::FROM_BASE, self::TO_BASE),
            rand(self::RAND_FROM, self::RAND_TO)
        );
    }
}
