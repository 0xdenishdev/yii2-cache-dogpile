<?php

namespace Hexspeak\Dogpile\Caching\Mixins;

use yii\caching\MemCache as MemCacheAncestor;
use Hexspeak\Dogpile\Caching\CacheInterface;
use Hexspeak\Dogpile\Caching\Mutexes\MutexAccessorInterface;

class MemCache extends MemCacheAncestor implements CacheInterface
{
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
    }

    public function setAdp()
    {
        // TODO: Implement setAdp() method.
        return $this->mutex;
    }

    public function getAdp()
    {
        // TODO: Implement getAdp() method.
    }
}