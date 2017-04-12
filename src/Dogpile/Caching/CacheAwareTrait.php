<?php

namespace Hexspeak\Dogpile\Caching;

/**
 * Class CacheAwareTrait.
 * Describes general layer which should be used by specific cache storage.
 *
 * @package Hexspeak\Dogpile\Caching
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
}