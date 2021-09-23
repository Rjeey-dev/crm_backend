<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth;

use Firebase\JWT\JWT;

class TokenGenerator
{
    private $secret;
    private $webSocketUrl;

    public function __construct(string $secret, string $webSocketUrl)
    {
        $this->secret = $secret;
        $this->webSocketUrl = $webSocketUrl;
    }

    public function generate(string $userId): string
    {
        return JWT::encode([
            'mercure' => [
                'subscribe' => [
                    sprintf('%s-%s', $this->webSocketUrl, $userId)
                ]
            ],
        ], $this->secret);
    }
}
