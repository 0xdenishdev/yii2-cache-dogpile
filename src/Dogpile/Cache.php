<?php

namespace Hexspeak\Dogpile;

use yii\base\Component;
use Hexspeak\Dogpile\Services\CacheServiceAbstract;

/**
 * Class Cache.
 * Component designed for solving dogpile cache issues.
 *
 * @package Hexspeak\Dogpile
 */
class Cache extends Component
{
    /**
     * Defines mutex accessor.
     *
     * @var array $mutexAccessor
     */
    public $mutexAccessor = [];

    /**
     * Defines default cache component.
     *
     * @var string $useComponent
     */
    public $useComponent  = 'cache';

    /**
     * Time interval for backuping a cache value in case of using persistent set/get mode.
     *
     * @var int $backupInterval
     */
    public $backupInterval = 10;

    /**
     * Defines cache service accessor.
     *
     * @var CacheServiceAbstract $cacheService
     */
    protected $cacheService = null;

    /**
     * Cache constructor.
     *
     * @param CacheServiceAbstract $cacheAccessor
     * @param array $config
     */
    public function __construct(CacheServiceAbstract $cacheAccessor, array $config = [])
    {
        parent::__construct($config);
        $this->cacheService  = $cacheAccessor;
        $this->cacheService->initMutex($this->mutexAccessor);
        $this->cacheService->setBackupInterval($this->backupInterval);
        $this->cacheService->setCacheEngine(\yii::$app->{$this->useComponent});
    }

    /**
     * Returns cache service.
     *
     * @return CacheServiceAbstract
     */
    public function getCacheAccessor()
    {
        return $this->cacheService;
    }
}
