<?php

namespace Hexspeak\Dogpile\Caching\Mutexes;

use yii\caching\Cache;

/**
 * Class Mutex.
 * Defines a default mutex behaviour.
 *
 * @package Hexspeak\Dogpile\Caching\Mutexes
 */
class MutexAccessor implements MutexAccessorInterface
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
     * Defines default wait time interval in which resource requester
     * waiting in hold mode until the lock will be released.
     *
     * @var int $timeToWait
     */
    protected $timeToWait     = 3000;

    /**
     * Defines default wait interval.
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
     * @param int $seconds
     */
    public function setWaitInterval($seconds)
    {
        $this->waitInterval = $seconds;
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
     * @inheritdoc
     */
    public function lock($key)
    {
        $mutexKey = $this->generateLockKey($key);
        $this->cache->set($mutexKey, MutexAccessorInterface::IS_LOCKED, $this->lockTtl);
    }

    /**
     * @inheritdoc
     */
    public function unlock($key)
    {
        $mutexKey = $this->generateLockKey($key);
        return $this->cache->delete($mutexKey);
    }

    /**
     * @inheritdoc
     */
    public function isReleased($key)
    {
        $mutexKey = $this->generateLockKey($key);
        return ! $this->cache->get($mutexKey);
    }

    /**
     * @inheritdoc
     */
    public function waitForUnlock($key)
    {
        $isUnlocked = $this->isReleased($key);
        $totalSlept = 0;

        while( ! $isUnlocked && $this->timeToWait > $totalSlept)
        {
            $totalSlept += $this->waitInterval;
            usleep($this->waitInterval);
        }

        return $totalSlept < $this->timeToWait;
    }

    /**
     * @inheritdoc
     */
    public function generateLockKey($key)
    {
        return $this->mutexKeyPrefix . $key;
    }
}
