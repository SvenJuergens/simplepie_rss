<?php

declare(strict_types=1);

namespace SvenJuergens\SimplepieRss\Cache;

use Psr\SimpleCache\CacheInterface;
use SvenJuergens\SimplepieRss\Cache\Exception\InvalidArgumentException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

/**
 * Bridges the TYPO3 Caching Framework to PSR-16, so it can be passed to
 * SimplePie::set_cache().
 */
final class Psr16CacheAdapter implements CacheInterface
{
    public function __construct(
        private readonly FrontendInterface $cache,
    ) {}

    public function get(string $key, mixed $default = null): mixed
    {
        $identifier = $this->identifier($key);
        if (!$this->cache->has($identifier)) {
            return $default;
        }
        return $this->cache->get($identifier);
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        $lifetime = $this->normalizeTtl($ttl);
        if ($lifetime !== null && $lifetime <= 0) {
            return $this->delete($key);
        }
        $this->cache->set($this->identifier($key), $value, [], $lifetime);
        return true;
    }

    public function delete(string $key): bool
    {
        return $this->cache->remove($this->identifier($key));
    }

    public function clear(): bool
    {
        $this->cache->flush();
        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $default);
        }
        return $result;
    }

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        $success = true;
        foreach ($values as $key => $value) {
            $success = $this->set((string)$key, $value, $ttl) && $success;
        }
        return $success;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        $success = true;
        foreach ($keys as $key) {
            $success = $this->delete($key) && $success;
        }
        return $success;
    }

    public function has(string $key): bool
    {
        return $this->cache->has($this->identifier($key));
    }

    /**
     * Maps an arbitrary PSR-16 key to a TYPO3 cache identifier
     * ([a-zA-Z0-9_-]). SimplePie generates URL-based keys that
     * contain reserved characters, so we hash them.
     */
    private function identifier(string $key): string
    {
        if ($key === '') {
            throw new InvalidArgumentException('Cache key must not be empty.', 1747000001);
        }
        return 'simplepie-' . sha1($key);
    }

    private function normalizeTtl(null|int|\DateInterval $ttl): ?int
    {
        if ($ttl === null) {
            return null;
        }
        if ($ttl instanceof \DateInterval) {
            $reference = new \DateTimeImmutable('@0');
            return $reference->add($ttl)->getTimestamp();
        }
        return $ttl;
    }
}
