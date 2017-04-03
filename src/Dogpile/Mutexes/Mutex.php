<?php

namespace Hexspeak\Dogpile\Mutexes;

/**
 * Class Mutex.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
class Mutex extends MutexAbstract
{
    /**
     * @inheritdoc
     */
    function isUnlocked()
    {
        return $this->_released === true;
    }

    /**
     * @inheritdoc
     */
    function isLocked()
    {
        return $this->_released === false;
    }
}
