<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth;

use App\Users\Infrastructure\Services\Auth\Clients\ClientInterface;
use App\Users\Infrastructure\Services\Auth\Clients\Google;

class PlatformAuthClientFactory implements AuthClientFactoryInterface
{
    private const PLATFORM_GOOGLE = 'google';

    private $google;

    public function __construct(Google $google)
    {
        $this->google = $google;
    }


    public function getAuthClient(string $platform): ClientInterface
    {
        switch ($platform) {
            case self::PLATFORM_GOOGLE:
                return $this->google;
        }

        throw new \InvalidArgumentException('platform is not supported');
    }
}
