<?php

namespace Xand\Component\Routing;

/**
 * Class CallbackResolver
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class CallbackResolver
{
    /**
     * @param mixed $callback
     *
     * @return mixed
     */
    public static function resolve($callback)
    {
        if (\is_string($callback) && false !== \strpos($callback, "@")) {
            return \explode("@", $callback);
        }

        return $callback;
    }
}