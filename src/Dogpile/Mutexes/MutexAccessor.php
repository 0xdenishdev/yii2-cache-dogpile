<?php

namespace Hexspeak\Dogpile\Mutexes;

use yii\caching\Cache;

/**
 * Class Mutex.
 * Defines a default behaviour of mutex.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
class MutexAccessor extends MutexAccessorAbstract
{
    /**
     * @inheritdoc
     */
    public function lock(Cache $cache, $key)
    {
        $mutexKey = $this->generateKey($key);
        return $cache->set($mutexKey, MutexConfig::IS_LOCKED);
    }

    /**
     * @inheritdoc
     */
    public function unlock(Cache $cache, $key)
    {
        $mutexKey = $this->generateKey($key);
        return $cache->set($mutexKey, MutexConfig::IS_UNLOCKED);
    }

    /**
     * @inheritdoc
     */
    public function isReleased(Cache $cache, $key)
    {
        $mutexKey = $this->generateKey($key);
        return $cache->get($mutexKey);
    }
}
