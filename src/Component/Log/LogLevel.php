<?php

namespace Xand\Component\Log;

/**
 * Class LogLevel
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
final class LogLevel
{
    /**
     * @const int
     */
    const DEBUG = 1;

    /**
     * @const int
     */
    const INFO = 2;

    /**
     * @const int
     */
    const WARNING = 4;

    /**
     * @const int
     */
    const ERROR = 8;

    /**
     * @const int
     */
    const FATAL = 16;
}