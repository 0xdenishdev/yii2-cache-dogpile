<?php

namespace Hexspeak\Dogpile;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\Cache as CacheStorage;

use Hexspeak\Dogpile\Storage\StorageInterface;
use Hexspeak\Dogpile\Services\CacheService;
use Hexspeak\Dogpile\Services\CacheServiceInterface;
use Hexspeak\Dogpile\Accessors\CacheServiceAccessorInterface;

use cheatsheet\Time;

/**
 * Class Cache.
 * Component designed for solving dogpile cache issues.
 *
 * @package Hexspeak\Dogpile
 */
class Cache extends Component implements StorageInterface, CacheServiceAccessorInterface
{
    /**
     * Defines cache lifetime.
     *
     * @var integer $ttl
     */
    public $ttl = Time::SECONDS_IN_A_MINUTE;

    /**
     * Defines an abstract storage
     *
     * @var \yii\caching\Cache $storage
     */
    protected $storage;

    /**
     * Defines cache service.
     *
     * @var CacheServiceInterface $cacheService
     */
    protected $cacheService;

    /**
     * Initializes this application component.
     * It creates the cache service manager instance.
     */
    public function init()
    {
        parent::init();
        $this->cacheService = new CacheService();
    }

    /**
     * @inheritdoc
     */
    public function setStorage(CacheStorage $cacheStorage)
    {
        $this->storage = $cacheStorage;
        return $this;
    }

    public function getCacheService()
    {
        return $this->cacheService;
    }

    /**
     * @inheritdoc
     */
    public function getStorage()
    {
        if (is_null($this->storage)) {
            throw new InvalidConfigException(
                'Cache storage was not properly configured. Specify a valid storage class.'
            );
        }

        return $this->storage;
    }

    /**
     * @inheritdoc
     */
    public function setService(CacheServiceInterface $cacheService)
    {
        $this->cacheService = $cacheService;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getService()
    {
        return $this->cacheService;
    }
}
