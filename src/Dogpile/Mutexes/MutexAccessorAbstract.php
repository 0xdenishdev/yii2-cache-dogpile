<?php

namespace Hexspeak\Dogpile\Mutexes;

use yii\caching\Cache;

/**
 * Class MutexAccessorAbstract.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
abstract class MutexAccessorAbstract implements MutexAccessorInterface
{
    /**
     * Defines default mutex cache key prefix.
     *
     * @var string $mutexKeyPrefix
     */
    protected $_mutexKeyPrefix = 'mutex_';

    /**
     * Defines default wait time interval in which resource requester
     * waiting in hold mode until the lock will be released.
     *
     * @var int $timeToWait
     */
    protected $_timeToWait     = 3000;

    /**
     * Defines default wait interval.
     * Wait interval is used for checking the lock status.
     *
     * @var int $waitInterval
     */
    protected $_waitInterval    = 300;


    /**
     * Defines default time to live for a lock key.
     *
     * @var int $_lockTtl
     */
    protected $_lockTtl         = 3600;

    /**
     * Defines cache engine.
     *
     * @var Cache|null
     */
    protected $_cacheEngine = null;

    /**
     * Sets wait interval.
     *
     * @param int $waitInterval
     */
    public function setWaitInterval($waitInterval)
    {
        $this->_waitInterval = $waitInterval;
    }

    /**
     * Returns wait interval.
     *
     * @return int
     */
    public function getWaitInterval()
    {
        return $this->_waitInterval;
    }

    /**
     * Sets time to wait.
     *
     * @param int $timeToWait
     */
    public function setTimeToWait($timeToWait)
    {
        $this->_timeToWait = $timeToWait;
    }

    /**
     * Returns time to wait.
     *
     * @return int
     */
    public function getTimeToWait()
    {
        return $this->_timeToWait;
    }

    /**
     * Sets mutex key prefix.
     *
     * @param string|int $prefix
     */
    public function setKeyPrefix($prefix)
    {
        $this->_mutexKeyPrefix = $prefix;
    }

    /**
     * Returns mutex key prefix.
     *
     * @return string
     */
    public function getKeyPrefix()
    {
        return $this->_mutexKeyPrefix;
    }

    /**
     * Sets lock key time to live.
     *
     * @param int $ttl
     */
    public function setLockKeyTtl($ttl)
    {
        $this->_lockTtl = $ttl;
    }

    /**
     * Returns lock key time to live.
     *
     * @return int
     */
    public function getLockKeyTtl()
    {
        return $this->_lockTtl;
    }

    /**
     * Returns cache engine.
     *
     * @return null|Cache
     */
    public function getCacheEngine()
    {
        return $this->_cacheEngine;
    }

    /**
     * Sets cache engine.
     *
     * @param Cache $cache
     */
    public function setCacheEngine(Cache $cache)
    {
        $this->_cacheEngine = $cache;
    }

    /**
     * Generates mutex key.
     *
     * @param mixed $key
     * @return string
     */
    public function generateKey($key)
    {
        return $this->_mutexKeyPrefix . $key;
    }

    /**
     * Generates backup cache key.
     *
     * @param string $backupKey
     * @param mixed $cacheKey
     * @return string
     */
    public function generateBackupKey($backupKey, $cacheKey)
    {
        return $backupKey . $cacheKey;
    }
}
