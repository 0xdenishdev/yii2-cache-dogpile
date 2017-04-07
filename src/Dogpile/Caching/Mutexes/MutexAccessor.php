<?php

namespace Hexspeak\Dogpile\Caching\Mutexes;

/**
 * Class Mutex.
 * Defines a default mutex behaviour.
 *
 * @package Hexspeak\Dogpile\Caching\Mutexes
 */
class MutexAccessor implements MutexAccessorInterface
{
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
    protected $lockTtl         = 3600;

    /**
     * Describes a behaviour of mutex lock.
     *
     * @param mixed $key
     * @return bool
     */
    public function lock($key)
    {
        // TODO: Implement lock() method.
    }

    /**
     * Describes a behaviour of mutex unlock.
     *
     * @param mixed $key
     * @return bool
     */
    public function unlock($key)
    {
        // TODO: Implement unlock() method.
    }

    /**
     * Returns true whether a mutex is released.
     *
     * @param mixed $key
     * @return bool
     */
    public function isReleased($key)
    {
        // TODO: Implement isReleased() method.
    }

    /**
     * Signals whether a mutex has been released.
     *
     * @param mixed $key
     * @return bool
     */
    public function waitForUnlock($key)
    {
        // TODO: Implement waitForUnlock() method.
    }
}
