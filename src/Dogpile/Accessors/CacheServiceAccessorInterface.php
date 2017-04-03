<?php

namespace Hexspeak\Dogpile\Accessors;

use Hexspeak\Dogpile\Services\CacheServiceInterface;

/**
 * Interface CacheServiceAccessorInterface.
 *
 * @package Hexspeak\Dogpile\Storage
 */
interface CacheServiceAccessorInterface
{
    /**
     * Sets cache service accessor.
     *
     * @param CacheServiceInterface $cacheService
     * @return void
     */
    public function setService(CacheServiceInterface $cacheService);

    /**
     * Returns cache service accessor.
     *
     * @return CacheServiceInterface
     */
    public function getService();
}