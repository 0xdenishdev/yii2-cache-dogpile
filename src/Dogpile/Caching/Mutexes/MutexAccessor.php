<?php

namespace Oxhexspeak\Dogpile\Caching\Mutexes;

/**
 * Class Mutex.
 * Defines a default mutex behaviour.
 *
 * @package Oxhexspeak\Dogpile\Caching\Mutexes
 */
class MutexAccessor implements MutexAccessorInterface
{
    use MutexAwareTrait;

    /**
     * @inheritdoc
     */
    public function lock($key, $lockTtl = null)
    {
        $this->setLockTtl($lockTtl);

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
    public function waitForUnlock($key, $ttwait = null, $interval = null)
    {
        $this->setTimeToWait($ttwait);
        $this->setWaitInterval($interval);

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
