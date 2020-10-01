<?php

namespace Xand\Component\Log;

/**
 * Interface LoggerInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface LoggerInterface
{
    /**
     * @param int       $level
     * @param string    $message
     * @param array     $params
     */
    public function log($level, $message, array $params = []);
}