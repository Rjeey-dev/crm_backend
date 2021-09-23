<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Services\Auth\Clients;

use App\Users\Infrastructure\Services\Auth\DTO\User;
use App\Users\Infrastructure\Services\Auth\Exception\AuthException;

class Google extends BaseClient implements ClientInterface
{
    private const PROVIDER_NAME = 'google';
    private const SALT = 'google';
    private const KEY = 'google_secret_key';

    public function auth(array $params): User
    {
        try {
            $name = sprintf('%s %s', $params['first_name'], $params['last_name']);
            $login = empty($params['login']) || !$params['login'] ?
                strtolower(str_replace(' ', '.', transliterator_transliterate('Russian-Latin/BGN', $name))) :
                $params['login'];

            return new User(
                $this->generateUserId($params['user_id'], self::SALT, self::KEY),
                $login,
                self::PROVIDER_NAME,
                $name,
                $params['email'],
                $params['image']
            );
        } catch (\Throwable $e) {
            throw new AuthException('could not get auth');
        }
    }
}
