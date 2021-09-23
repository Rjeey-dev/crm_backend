<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Redis\DataProvider;

use App\Users\Domain\DataProvider\AuthInterface;
use App\Users\Domain\Exception\CacheException;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\ValueObject\UserId;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class Auth implements AuthInterface
{
    private $storage;

    public function __construct(AdapterInterface $storage)
    {
        $this->storage = $storage;
    }

    public function set(UserId $id, string $key): void
    {
        $item = $this->fetch($key);

        $item->set($id->getId());
        $item->expiresAt(new \DateTimeImmutable('+1 month'));

        $this->storage->save($item);
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key)
    {
        if (!$key) {
            throw new UserNotFoundException('');
        }

        $item = $this->fetch($key);
        if ($item->isHit()) {
            return $item->get();
        }

        throw new UserNotFoundException('');
    }

    public function delete(string $key): bool
    {
        return $this->storage->deleteItem($key);
    }

    public function deleteAll(): bool
    {
        return $this->storage->clear();
    }

    private function fetch(string $key): CacheItemInterface
    {
        try {
            return $this->storage->getItem($key);
        } catch (InvalidArgumentException $e) {
            throw new CacheException($e->getMessage());
        }
    }
}
