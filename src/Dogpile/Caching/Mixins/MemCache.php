<?php

namespace Hexspeak\Dogpile\Caching\Mixins;

use yii\caching\MemCache as MemCacheAncestor;
use Hexspeak\Dogpile\Caching\CacheInterface;
use Hexspeak\Dogpile\Caching\CacheAwareTrait;
use Hexspeak\Dogpile\Caching\Mutexes\MutexAccessorInterface;

/**
 * Class MemCache.
 * Defines a memcached implementation of preventing dogpile effect.
 *
 * @package Hexspeak\Dogpile\Caching\Mixins
 */
class MemCache extends MemCacheAncestor implements CacheInterface
{
    use CacheAwareTrait;

    /**
     * @var MutexAccessorInterface $mutex
     */
    protected $mutex;

    /**
     * MemCache constructor.
     *
     * @param MutexAccessorInterface $mutexAccessor
     * @param array $config
     */
    public function __construct(MutexAccessorInterface $mutexAccessor, array $config = [])
    {
        parent::__construct($config);
        $this->mutex = $mutexAccessor;
        $this->mutex->setStorage($this);
    }

    /**
     * @inheritdoc
     */
    public function setSafe($key, \Closure $closure, $expiresInSeconds = 3600, $lockTtl = 5)
    {
        $isMutexReleased = $this->mutex->waitForUnlock($key);

        if ($isMutexReleased)
        {
            $this->mutex->lock($key);

            $backupKey = $this->generateBackupKey($key);

            $callbackResult = call_user_func($closure, $this);
            $cached = $this->assembleValue($callbackResult, $expiresInSeconds);

            // Set actual data
            $this->setValue($key, $cached, 0);
            // Set backup data
            $this->setValue($backupKey, $callbackResult, $expiresInSeconds + $lockTtl + $this->backupInterval);

            $this->mutex->unlock($key);

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getSafe($key, \Closure $closure, $expiresInSeconds = 3600, $lockTtl = 10)
    {
        if (($value = $this->isAvailable($key)) !== false)
        {
            return $value;
        }

        // In case of no cache, set from callable
        if ( ! ($value = $this->setSafe($key, $closure, $expiresInSeconds, $lockTtl)))
        {
            // If mutex has not been released yet, return stale cache from backup
            return $this->getValue($this->generateBackupKey($key));
        }

        // Else return actual data
        return $this->getValue($key);
    }
}