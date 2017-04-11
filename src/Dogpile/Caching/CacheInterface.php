<?php

namespace Hexspeak\Dogpile\Caching;

/**
 * Interface CacheInterface.
 * Defines an interface that should be implemented by a specific cache.
 *
 * @package Hexspeak\Dogpile\Caching
 */
interface CacheInterface
{
    /**
     * Stores a value identified by a key into cache with backup mode.
     *
     * @param $key
     * @param callable $callback
     * @param int $ttl
     * @return bool
     */
    public function setSafe($key, callable $callback, $ttl = 0);

    /**
     * Retrieves a value from cache with a specified key with backup mode.
     *
     * @param mixed $key
     * @param callable $callback
     * @return mixed
     */
    public function getSafe($key, callable $callback);

    /**
     * Returns cache value composed with expire data.
     *
     * @param mixed $value
     * @param int $ttl
     * @return array
     */
    public function assembleValue($value, $ttl = 0);
}