<?php

namespace Xand\Component\Foundation\Http;

/**
 * Class Headers
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class HeadersInflector
{
    /**
     * @param array $server
     *
     * @return array
     */
    public static function getHeaders(array $server)
    {
        $headers = [];
        foreach($_SERVER as $key => $value) {
            if (false === \strpos($key, "HTTP_"))
                continue;

            $header = static::normalize(substr($key, 5));
            if ( ! isset($headers[$header]))
                $headers[$header] = [];

            $headers[$header][] = $value;
        }

        /* @var array $headers */
        $headers = \array_change_key_case($headers, CASE_LOWER);

        return $headers;
    }

    /**
     * @param string $header
     *
     * @return string
     */
    public static function normalize($header)
    {
        return strtolower(str_replace(["_", " "], "-", $header));
    }
}