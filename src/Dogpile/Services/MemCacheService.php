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
        $cache = $this->getCacheEngine();
        $mutex = $this->getMutex();

        $isReleased = $mutex->waitForUnlock($key);
        if ($isReleased) {
            $mutex->lock($key);
            $cache->set($key, $this->assembleValue($value, $ttl));
            $mutex->unlock($key);

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function setPersistent($key, $value, $ttl = 0)
    {
        $cache  = $this->getCacheEngine();
        $mutex  = $this->getMutex();
        $backup = $mutex->generateBackupKey($this->getBackupKeyPrefix(), $key);

        $isReleased = $mutex->waitForUnlock($key);
        if ($isReleased) {
            $mutex->lock($key);

            $cache->set($key, $this->assembleValue($value, $ttl));
            $cache->set($backup, $this->assembleValue($cache));

            $mutex->unlock($key);

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        $cache = $this->getCacheEngine();
        $mutex = $this->getMutex();

        $isReleased = $mutex->waitForUnlock($key);
        if ($isReleased) {
            $mutex->lock($key);
            if ($this->isExpired($key)) {
                $mutex->unlock($key);
                $cache->delete($key);
                return false;
            }

            $cached = $cache->get($key);
            $mutex->unlock($key);

            return $cached['data'];
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getPersistent($key)
    {
        $cache  = $this->getCacheEngine();
        $mutex  = $this->getMutex();
        $backup = $mutex->generateBackupKey($this->getBackupKeyPrefix(), $key);

        $isReleased = $mutex->waitForUnlock($key);
        if ($isReleased) {
            $mutex->lock($key);
            if ($this->isExpired($key)) {
                $mutex->unlock($key);
                $cache->delete($key);
                return false;
            }

            $cached = $cache->get($key);
            $mutex->unlock($key);

            return $cached['data'];
        }

        $cached = $cache->get($backup);
        return $cached['data'];
    }
}
