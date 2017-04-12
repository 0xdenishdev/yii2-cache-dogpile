<?php

namespace Oxhexspeak\Dogpile\Caching;

/**
 * Class CacheAwareTrait.
 * Describes general layer which should be used by specific cache storage.
 *
 * @package Oxhexspeak\Dogpile\Caching
 */
trait CacheAwareTrait
{
    /**
     * Defines default backup cache key prefix.
     *
     * @var string $backupKeyPrefix
     */
    protected $backupKeyPrefix = 'backup_';

    /**
     * Defines backup interval in seconds.
     *
     * @var int $backupInterval
     */
    protected $backupInterval  = 10;

    /**
     * Sets backup cache key prefix.
     *
     * @param string $prefix
     */
    public function setBackupKeyPrefix($prefix)
    {
        $this->backupKeyPrefix = $prefix;
    }

    /**
     * Generates backup cache key.
     *
     * @param string $key
     * @return string
     */
    public function generateBackupKey($key)
    {
        return $this->backupKeyPrefix . $key;
    }

    /**
     * Returns cache value composed with expire data.
     *
     * @param mixed $value
     * @param int $ttl
     * @return array
     */
    public function assembleValue($value, $ttl = 0)
    {
        return [
            'data'       => $value,
            'expires_in' => time() + $ttl
        ];
    }

    /**
     * Checks whether a value exists in cache and it has not been expired yet.
     *
     * @param mixed $key
     * @return mixed
     */
    public function isAvailable($key)
    {
        // Check if value exists in cache
        if (($value = $this->getValue($key)) === false)
        {
            return false;
        }

        // Check if cache was expired
        if ($this->isExpired($value))
        {
            $this->delete($key);
            return false;
        }

        return $value['data'];
    }

    /**
     * Checks whether a value in cache is expired.
     *
     * @param array $value
     * @return bool
     */
    protected function isExpired($value)
    {
        return $value['expires_in'] < time();
    }
}