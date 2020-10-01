<?php

namespace Xand\Component\Database\ActiveRecord;

/**
 * Class ActiveRecordInflector
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ActiveRecordInflector
{
    /**
     * Camelization underscored string.
     *
     * Example:
     * echo ActiveRecordInflector::camelize("my_table");
     *      Output: MyTable
     *
     * @param string $string
     *
     * @return string
     */
    public static function camelize($string)
    {
        return implode("", array_map("ucfirst", explode("_", $string)));
    }

    /**
     * Camelize string to underscored.
     *
     * Example:
     * echo ActiveRecordInflector::underscore("MyTable");
     *      Output: my_table
     *
     * @param string $string
     *
     * @return string
     */
    public static function underscore($string)
    {
        return \strtolower(\preg_replace('/([A-Z]+)([A-Z])/','\1_\2',
            \preg_replace('/([a-z\d])([A-Z])/','\1_\2', $string)));
    }

    /**
     * Humanization underscored string.
     *
     * Example:
     * echo ActiveRecordInflector::humanize("my_underscored_string");
     *      Output: my underscored string
     *
     * @param string $string
     *
     * @return string
     */
    public static function humanize($string)
    {
        return ucfirst(strtolower(preg_replace('/_/', ' ', strval($string))));
    }

    /**
     * @see \Xand\Component\Database\ActiveRecord\ActiveRecordInflector::underscore()
     *
     * @param string $className
     *
     * @return string
     */
    public static function tableize($className)
    {
        return static::underscore($className);
    }

    /**
     * @see \Xand\Component\Database\ActiveRecord\ActiveRecordInflector::camelize()
     *
     * @param string $tableName
     *
     * @return string
     */
    public static function classify($tableName)
    {
        return static::camelize($tableName);
    }
}