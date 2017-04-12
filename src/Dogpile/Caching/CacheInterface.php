<?php

namespace Oxhexspeak\Dogpile\Caching;

/**
 * Interface CacheInterface.
 * Defines an interface that should be implemented by a specific cache.
 *
 * @package Oxhexspeak\Dogpile\Caching
 */
interface CacheInterface
{
    /**
     * Stores a value identified by a key into cache with backup mode.
     *
     * @param mixed $key
     * @param \Closure $closure     - the closure that will be used to generate a value to be cached.
     * @param int $expiresInSeconds - cache expire date evaluates by formula: time() + seconds
     *                                that is used for setting fresh value from callable function in case of stale cache.
     * @param int $lockTtl          - mutex lock time to live
     * @param int $timeToWait       - wait time interval in which resource requester waiting in hold mode until the lock will be released.
     * @param int $interval         - interval in microseconds is used for periodic checking the lock status.
     * @return bool
     */
    public function setSafe($key, \Closure $closure, $expiresInSeconds = 3600, $lockTtl = 10, $timeToWait = null, $interval = null);

    /**
     * Retrieves a value from cache with a specified key with backup mode.
     *
     * @param mixed $key
     * @param \Closure $closure     - the closure that will be used to generate a value to be cached.
     * @param int $expiresInSeconds - cache expire date evaluates by formula: time() + seconds
     *                                that is used for setting fresh value from callable function in case of stale cache.
     * @param int $lockTtl          - mutex lock time to live in case of stale cache.
     * @param int $timeToWait       - wait time interval in which resource requester waiting in hold mode until the lock will be released.
     * @param int $interval         - interval in microseconds is used for periodic checking the lock status.
     * @return mixed
     */
    public function getSafe($key, \Closure $closure, $expiresInSeconds = 3600, $lockTtl = 10, $timeToWait = null, $interval = null);
}