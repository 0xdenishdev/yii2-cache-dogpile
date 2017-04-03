<?php

namespace Hexspeak\Dogpile\Mutexes;

/**
 * Class MutexAbstract.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
abstract class MutexAbstract
{
    /**
     * Defines mutex cache key prefix.
     *
     * @var string $mutexKeyPrefix
     */
    protected $mutexKeyPrefix = 'mutex_';
}
