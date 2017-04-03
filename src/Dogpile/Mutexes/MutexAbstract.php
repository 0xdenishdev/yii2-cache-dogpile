<?php

namespace Hexspeak\Dogpile\Mutexes;

/**
 * Class MutexAbstract.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
abstract class MutexAbstract implements MutexAccessorInterface
{
    /**
     * Defines default mutex cache key prefix.
     *
     * @var string $mutexKeyPrefix
     */
    protected $mutexKeyPrefix = 'mutex_';

    /**
     * Defines default wait time interval in which resource requester
     * waiting in hold mode until the lock will be released.
     *
     * @var int $timeToWait
     */
    protected $timeToWait   = 3000;

    /**
     * Defines default wait interval.
     * Wait interval is used for checking the lock status.
     *
     * @var int $waitInterval
     */
    protected $waitInterval = 300;

    /**
     * Defines lock flag.
     * Whether variable is true the mutex is unlocked.
     *
     * @var bool
     */
    protected $_released   = true;

    /**
     * @inheritdoc
     */
    public function setWaitInterval($waitInterval)
    {
        $this->waitInterval = $waitInterval;
    }

    /**
     * @inheritdoc
     */
    public function getWaitInterval()
    {
        return $this->waitInterval;
    }

    /**
     * @inheritdoc
     */
    public function setTimeToWait($timeToWait)
    {
        $this->timeToWait = $timeToWait;
    }

    /**
     * @inheritdoc
     */
    public function getTimeToWait()
    {
        return $this->timeToWait;
    }

    /**
     * Describes a behaviour of mutex unlocking check.
     *
     * @return bool
     */
    abstract function isUnlocked();

    /**
     * Describes a behaviour of mutex locking check
     *
     * @return bool
     */
    abstract function isLocked();
}
