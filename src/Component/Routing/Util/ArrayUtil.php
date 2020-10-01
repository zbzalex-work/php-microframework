<?php

namespace Xand\Component\Routing\Util;

/**
 * Class ArrayUtil
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ArrayUtil
{
    /**
     * @param array $array
     *
     * @return array
     */
    public static function toAssocArray(array $array)
    {
        $keys = \array_keys($array);
        foreach($keys as $index => $key) {
            if (\preg_match("/^[0-9]+/", $key)) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}