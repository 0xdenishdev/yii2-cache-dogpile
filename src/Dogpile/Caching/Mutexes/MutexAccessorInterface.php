<?php

namespace Hexspeak\Dogpile\Caching\Mutexes;

/**
 * Interface MutexAccessorInterface.
 * Defines an interface that should be implemented by a specific mutex.
 *
 * @package Hexspeak\Dogpile\Caching\Mutexes
 */
interface MutexAccessorInterface
{
    /** Defines a locked mutex mode. */
    const IS_LOCKED = 1;

    /**
     * Describes a behaviour of mutex lock.
     *
     * @param mixed $key
     * @return bool
     */
    public function lock($key);

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
     * @return bool
     */
    public function waitForUnlock($key);

    /**
     * Generates mutex lock key.
     *
     * @param mixed $key
     * @return string
     */
    public function generateLockKey($key);
}
