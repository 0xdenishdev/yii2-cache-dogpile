<?php

namespace Hexspeak\Dogpile\Mutexes;

/**
 * Class Mutex.
 * Defines a default mutex behaviour.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
class MutexAccessor extends MutexAccessorAbstract
{
    /**
     * @inheritdoc
     */
    public function lock($key)
    {
        $mutexKey = $this->generateKey($key);
        return $this->getCacheEngine()->set($mutexKey, MutexConfig::IS_LOCKED);
    }

    /**
     * @inheritdoc
     */
    public function unlock($key)
    {
        $mutexKey = $this->generateKey($key);
        return $this->getCacheEngine()->set($mutexKey, MutexConfig::IS_UNLOCKED, $this->getLockKeyTtl());
    }

    /**
     * @inheritdoc
     */
    public function isReleased($key)
    {
        $mutexKey = $this->generateKey($key);
        return $this->getCacheEngine()->get($mutexKey);
    }

    /**
     * @inheritdoc
     */
    public function waitForUnlock($key)
    {
        $isUnlocked = $this->isReleased($key);
        $sleepTime  = $this->getWaitInterval();
        $totalSlept = 0;

        while (! $isUnlocked && $this->getTimeToWait() > $totalSlept ) {
            $totalSlept += $this->getWaitInterval();
            usleep($sleepTime);
        }

        return $totalSlept < $this->getTimeToWait();
    }
}
