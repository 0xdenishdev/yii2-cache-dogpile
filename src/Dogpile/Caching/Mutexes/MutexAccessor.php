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
    use MutexAwareTrait;

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
}
