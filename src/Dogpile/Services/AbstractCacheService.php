<?php

namespace Hexspeak\Dogpile\Services;

use yii\caching\Cache;
use Hexspeak\Dogpile\Mutexes\Mutex;
use Hexspeak\Dogpile\Mutexes\MutexCore;
use Hexspeak\Dogpile\Mutexes\MutexAccessorInterface;

/**
 * Class AbstractCacheService.
 * Describes an abstract layer which should be implemented by specific cache storage.
 *
 * @package Hexspeak\Dogpile\Services
 */
abstract class AbstractCacheService
{
    /**
     * Defines mutex that servers as a cache locker
     * preventing dogpile effect.
     *
     * @var \Hexspeak\Dogpile\Mutexes\MutexAccessorInterface $_mutex
     */
    protected $_mutex;

    /**
     * Defines cache engine.
     *
     * @var Cache $cacheEngine
     */
    protected $cacheEngine;

    /**
     * AbstractCacheService constructor.
     */
    public function __construct()
    {
        $this->_mutex = new Mutex();
    }

    /**
     * Returns current mutex accessor.
     *
     * @return MutexCore
     */
    public function getMutexAccessor()
    {
        return $this->_mutex;
    }

    /**
     * Overrides default mutex accessor.
     *
     * @param MutexAccessorInterface $mutexAccessor
     */
    protected function overrideMutexAccessor(MutexAccessorInterface $mutexAccessor)
    {
        $this->_mutex = $mutexAccessor;
    }

    /**
     * Sets cache engine.
     *
     * @param Cache $cache
     * @return void
     */
    abstract function setCacheEngine(Cache $cache);

    /**
     * Returns cache engine.
     *
     * @return Cache
     */
    abstract function getCacheEngine();
}
