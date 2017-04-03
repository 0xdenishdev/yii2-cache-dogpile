<?php

namespace Hexspeak\Dogpile;

use yii\base\Component;
use Hexspeak\Dogpile\Services\AbstractCacheService;
use cheatsheet\Time;

/**
 * Class Cache.
 * Component designed for solving dogpile cache issues.
 *
 * @package Hexspeak\Dogpile
 */
class Cache extends Component
{
    /**
     * Defines cache lifetime.
     *
     * @var integer $ttl
     */
    public $ttl = Time::SECONDS_IN_A_MINUTE;

    /**
     * Defines cache engine.
     *
     * @var null|\yii\caching\Cache $engine
     */
    public $engine = null;

    /**
     * Defines cache service accessor.
     *
     * @var AbstractCacheService $cacheService
     */
    protected $cacheService;

    public function __construct(AbstractCacheService $cacheAccessor, array $config = [])
    {
//        $this->engine = '\yii\caching\MemCache';
        $this->cacheService = $cacheAccessor;
        $this->cacheService->setCacheEngine(new $this->engine);
        parent::__construct($config);
    }

    /**
     * Returns cache service.
     *
     * @return AbstractCacheService
     */
    public function getCacheService()
    {
        return $this->cacheService;
    }
}
