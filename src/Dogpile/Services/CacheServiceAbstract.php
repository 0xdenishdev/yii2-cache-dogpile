<?php

namespace Hexspeak\Dogpile\Services;

use yii\caching\Cache;
use yii\base\InvalidConfigException;
use Hexspeak\Dogpile\Mutexes\MutexConfig;
use Hexspeak\Dogpile\Mutexes\MutexAccessorAbstract;

/**
 * Class CacheServiceAbstract.
 * Describes an abstract layer which should be implemented by specific cache storage.
 *
 * @package Hexspeak\Dogpile\Services
 */
abstract class CacheServiceAbstract implements CacheServiceInterface
{
    /**
     * Defines mutex that servers as a cache locker
     * preventing dogpile effect.
     *
     * @var \Hexspeak\Dogpile\Mutexes\MutexAccessorAbstract $_mutex
     */
    protected $_mutex;

    /**
     * Defines cache engine.
     *
     * @var Cache $_cacheEngine
     */
    protected $_cacheEngine;

    /**
     * Defines backup key prefix.
     *
     * @var string $_backupKeyPrefix
     */
    protected $_backupKeyPrefix = 'backup_';

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
     * Returns cache engine.
     *
     * @return Cache
     */
    public function getCacheEngine()
    {
        return $this->_cacheEngine;
    }

    /**
     * Returns mutex accessor.
     *
     * @return MutexAccessorAbstract
     */
    public function getMutex()
    {
        return $this->_mutex;
    }

    /**
     * Initialize mutex accessor.
     *
     * @param array $mutexAccessorConfig
     * @throws InvalidConfigException
     */
    public function initMutex(array $mutexAccessorConfig)
    {
        $accessor = isset($mutexAccessorConfig[MutexConfig::ACCESSOR_CLASS_KEY])
            ? $mutexAccessorConfig[MutexConfig::ACCESSOR_CLASS_KEY]
            : MutexConfig::ACCESSOR_DEFAULT_CLASS
            ;

        if ( ! is_subclass_of($accessor, MutexAccessorAbstract::class)) {
            throw new InvalidConfigException(MutexConfig::ACCESSOR_CLASS_KEY . ' should be derived from MutexAccessorAbstract.');
        }

        /** @var MutexAccessorAbstract $mutex */
        $mutex = new $accessor;

        $mutex->setTimeToWait(
            isset($mutexAccessorConfig[MutexConfig::ACCESSOR_WAIT_KEY])
                ? $mutexAccessorConfig[MutexConfig::ACCESSOR_WAIT_KEY] :
                $mutex->getTimeToWait()
        );

        $mutex->setWaitInterval(
            isset($mutexAccessorConfig[MutexConfig::ACCESSOR_WAIT_KEY])
                ? $mutexAccessorConfig[MutexConfig::ACCESSOR_WAIT_KEY]
                : $mutex->getWaitInterval()
        );

        $this->_mutex = $mutex;
    }
}
