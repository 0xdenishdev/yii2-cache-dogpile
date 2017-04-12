<?php

namespace Oxhexspeak\Dogpile\Caching\Mutexes;

use yii\caching\Cache;

/**
 * Class MutexAwareTrait.
 * Describes general layer which should be used by specific mutex accessor.
 *
 * @package Oxhexspeak\Dogpile\Caching\Mutexes
 */
trait MutexAwareTrait
{
    /**
     * Defines cache engine.
     *
     * @var Cache $cache
     */
    protected $cache;

    /**
     * Defines default mutex cache key prefix.
     *
     * @var string $mutexKeyPrefix
     */
    protected $mutexKeyPrefix = 'mutex_';

    /**
     * Defines default wait time interval in seconds in which resource requester
     * waiting in hold mode until the lock will be released.
     *
     * @var int $timeToWait
     */
    protected $timeToWait     = 3000;

    /**
     * Defines default wait interval in microseconds.
     * Wait interval is used for checking the lock status.
     *
     * @var int $waitInterval
     */
    protected $waitInterval    = 300;

    /**
     * Defines default time to live for a lock key.
     *
     * @var int $lockTtl
     */
    protected $lockTtl         = 5;

    /**
     * Sets time to wait.
     *
     * @param int $seconds
     */
    public function setTimeToWait($seconds)
    {
        $this->timeToWait = $seconds;
    }

    /**
     * Sets wait interval.
     *
     * @param int $microseconds
     */
    public function setWaitInterval($microseconds)
    {
        $this->waitInterval = $microseconds;
    }

    /**
     * Sets lock time to live.
     *
     * @param int $seconds
     */
    public function setLockTtl($seconds)
    {
        $this->lockTtl = $seconds;
    }

    /**
     * Sets cache engine.
     *
     * @param Cache $cache
     */
    public function setStorage(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Generates mutex lock key.
     *
     * @param string $key
     * @return string
     */
    public function generateLockKey($key)
    {
        return $this->mutexKeyPrefix . $key;
    }
}