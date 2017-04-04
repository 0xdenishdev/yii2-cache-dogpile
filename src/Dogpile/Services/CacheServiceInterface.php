<?php

namespace Hexspeak\Dogpile\Services;

/**
 * Interface CacheServiceInterface.
 * Defines an interface that should be implemented by a specific cache manager.
 *
 * @package Hexspeak\Dogpile\Services
 */
interface CacheServiceInterface
{
    /**
     * Stores a value identified by a key into cache.
     *
     * @param mixed $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = 0);

    /**
     * Stores a value identified by a key into cache with backup mode.
     *
     * @param mixed $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function setPersistent($key, $value, $ttl = 0);

    /**
     * Retrieves a value from cache with a specified key.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key);

    /**
     * Retrieves a value from cache with a specified key with backup mode.
     *
     * @param mixed $key
     * @return mixed
     */
    public function getPersistent($key);

    /**
     * Checks whether a value in cache is expired.
     *
     * @param mixed $key
     * @return bool
     */
    public function isExpired($key);
}