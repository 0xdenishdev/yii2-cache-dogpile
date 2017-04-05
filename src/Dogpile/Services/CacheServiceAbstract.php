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
     * Time interval for backuping a cache value.
     *
     * @var int $_backupInterval
     */
    protected $_backupInterval;

    /** Sets cache engine. @param Cache $cache */
    public function setCacheEngine(Cache $cache) {$this->_cacheEngine = $cache;}

    /** Returns cache engine. @return Cache */
    public function getCacheEngine() {return $this->_cacheEngine;}

    /* Sets backup cache key prefix. @param string $prefix */
    public function setBackupKeyPrefix($prefix) {$this->_backupKeyPrefix = $prefix;}

    /** Returns backup cache key prefix. @return string */
    public function getBackupKeyPrefix() {return $this->_backupKeyPrefix;}

    /** Sets backup time interval. @param int $ttl */
    public function setBackupInterval($ttl) {$this->_backupInterval = $ttl;}

    /** Returns backup time interval. @return int */
    public function getBackupInterval() {return $this->_backupInterval;}

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
     * Returns cache value composed with expire data.
     *
     * @param mixed $cacheValue
     * @param int $ttl
     * @return array
     */
    public function assembleValue($cacheValue, $ttl = 0)
    {
        return [
            'data'       => $cacheValue,
            'expires_in' => time() + $ttl
        ];
    }

    /**
     * @inheritdoc
     */
    public function isExpired($key)
    {
        $cached = $this->_cacheEngine->get($key);
        return $cached['expires_in'] > time();
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

        $mutex->setLockKeyTtl(
            isset($mutexAccessorConfig[MutexConfig::ACCESSOR_LOCK_TTL_KEY])
                ? $mutexAccessorConfig[MutexConfig::ACCESSOR_LOCK_TTL_KEY]
                : $mutex->getLockKeyTtl()
        );

        $this->_mutex = $mutex;
    }
}
