<?php

namespace Hexspeak\Dogpile\Mutexes;

/**
 * Interface MutexAccessorInterface.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
interface MutexAccessorInterface
{
    /** Sets wait interval. @param $waitInterval */
    public function setWaitInterval($waitInterval);

    /** Returns wait interval. @return int */
    public function getWaitInterval();

    /** Sets time to wait. @param int $timeToWait */
    public function setTimeToWait($timeToWait);

    /** Gets time to wait. @return int */
    public function getTimeToWait();
}
