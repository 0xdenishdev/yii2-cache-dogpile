<?php

namespace Oxhexspeak\Dogpile\Caching\Mutexes;

/**
 * Interface MutexAccessorInterface.
 * Defines an interface that should be implemented by a specific mutex.
 *
 * @package Oxhexspeak\Dogpile\Caching\Mutexes
 */
interface MutexAccessorInterface
{
    /** Defines a locked mutex mode. */
    const IS_LOCKED = 1;

    /**
     * Describes a behaviour of mutex lock.
     *
     * @param mixed $key
     * @param int $lockTtl - lock key time to live
     * @return bool
     */
    public function lock($key, $lockTtl = null);

    /**
     * Describes a behaviour of mutex unlock.
     *
     * @param mixed $key
     * @return bool
     */
    public function unlock($key);

    /**
     * Returns true whether a mutex is released.
     *
     * @param mixed $key
     * @return bool
     */
    public function isReleased($key);

    /**
     * Signals whether a mutex has been released.
     *
     * @param mixed $key
     * @param int $ttwait   - wait time interval in which resource requester
     *                        waiting in hold mode until the lock will be released.
     * @param int $interval - interval in microseconds is used for periodic checking the lock status.
     * @return bool
     */
    public function waitForUnlock($key, $ttwait = null, $interval = null);
}
