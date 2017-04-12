<?php

namespace Hexspeak\Dogpile\Caching\Mixins;

use yii\caching\MemCache as MemCacheAncestor;
use Hexspeak\Dogpile\Caching\CacheAwareTrait;
use Hexspeak\Dogpile\Caching\CacheInterface;
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
    public function setSafe($key, callable $callback, $ttl = 0)
    {
        // TODO: Implement setSafe() method.
    }

    /**
     * @inheritdoc
     */
    public function getSafe($key, callable $callback)
    {
        // TODO: Implement getSafe() method.
    }

    /**
     * @inheritdoc
     */
    public function assembleValue($value, $ttl = 0)
    {
        return [
            'data'       => $value,
            'expires_in' => time() + $ttl
        ];
    }
}