<?php

namespace Hexspeak\Dogpile\Mutexes;

/**
 * Class MutexConfig.
 * Defines mutex specification.
 *
 * @package Hexspeak\Dogpile\Mutexes
 */
class MutexConfig
{
    /** Defines accessor class key. */
    const ACCESSOR_CLASS_KEY     = 'accessorClass';

    /** Defines mutex time to wait key. */
    const ACCESSOR_WAIT_KEY      = 'timeToWait';

    /** Defines mutex interval key. */
    const ACCESSOR_INTERVAL_KEY  = 'timeInterval';

    /** Defines lock's time to live key. */
    const ACCESSOR_LOCK_TTL_KEY  = 'lockTtl';

    /** Defines mutex default class name. */
    const ACCESSOR_DEFAULT_CLASS = '\Hexspeak\Dogpile\Mutexes\MutexAccessor';

    /** Defines a locked mutex mode. */
    const IS_LOCKED   = true;

    /** Defines an unlocked mutex mode. */
    const IS_UNLOCKED = false;
}
