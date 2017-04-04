<?php

namespace Hexspeak\Dogpile\Services;

/**
 * Class MemCacheService.
 * Defines a memcached implementation of preventing an anti dogpile effect.
 *
 * @package Hexspeak\Dogpile\Services
 */
class MemCacheService extends CacheServiceAbstract
{
    /**
     * @inheritdoc
     */
    public function set($key, $value, $ttl = 0)
    {
        // TODO: Implement set() method.
    }

    /**
     * @inheritdoc
     */
    public function setPersistent($key, $value, $ttl = 0)
    {
        // TODO: Implement setPersistent() method.
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritdoc
     */
    public function getPersistent($key)
    {
        // TODO: Implement getPersistent() method.
    }

    /**
     * @inheritdoc
     */
    public function isExpired($key)
    {
        // TODO: Implement isExpired() method.
    }
}
