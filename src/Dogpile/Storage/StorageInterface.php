<?php

namespace Hexspeak\Dogpile\Storage;

use yii\caching\Cache as CacheStorage;
use yii\base\InvalidConfigException;

/**
 * Interface StorageInterface.
 * Describes an interface which should be implemented by specific cache storage.
 *
 * @package Hexspeak\Dogpile\Storage
 */
interface StorageInterface
{
    /**
     * Sets cache storage.
     *
     * @param CacheStorage $cacheStorage
     * @return void
     */
    public function setStorage(CacheStorage $cacheStorage);

    /**
     * Gets cache storage.
     *
     * @return mixed
     * @throws InvalidConfigException
     */
    public function getStorage();
}
