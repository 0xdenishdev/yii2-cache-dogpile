<?php

namespace Hexspeak\Dogpile\Mutexes;

use yii\caching\Cache;

/**
 * Class MutexAccessorAbstract.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
abstract class MutexAccessorAbstract
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
     * Returns mutex key prefix.
     *
     * @return string
     */
    public function getKeyPrefix()
    {
        return $this->_mutexKeyPrefix;
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
     * Describes a behaviour of mutex lock.
     *
     * @param Cache $cache
     * @param mixed $key
     * @return bool
     */
    abstract public function lock(Cache $cache, $key);

    /**
     * Describes a behaviour of mutex unlock.
     *
     * @param Cache $cache
     * @param mixed $key
     * @return bool
     */
    abstract public function unlock(Cache $cache, $key);

    /**
     * Returns true whether a mutex is released.
     *
     * @param Cache $cache
     * @param mixed $key
     * @return bool
     */
    abstract public function isReleased(Cache $cache, $key);
}
