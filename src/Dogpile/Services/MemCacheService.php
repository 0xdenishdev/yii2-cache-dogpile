<?php

namespace Hexspeak\Dogpile\Services;

use yii\caching\Cache;

/**
 * Class MemCacheService.
 *
 * @package Hexspeak\Dogpile\Services
 */
class MemCacheService extends AbstractCacheService
{
    /**
     * @inheritdoc
     */
    function setCacheEngine(Cache $cache)
    {
        $this->cacheEngine = $cache;
    }

    /**
     * @inheritdoc
     */
    function getCacheEngine()
    {
        return $this->cacheEngine;
    }

    // TODO: Implement cache locking functionality here.
}
