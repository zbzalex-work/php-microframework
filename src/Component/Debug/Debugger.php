<?php

namespace Xand\Component\Debug;

/**
 * Class Debugger
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Debugger
{
    /**
     * @var bool
     */
    private static $enabled = false;

    /**
     * Enable debugging.
     */
    public static function enable()
    {
        if (static::$enabled)
            return false;

        \error_reporting(0);
        ErrorHandler::register();

        static::$enabled = true;
    }
}