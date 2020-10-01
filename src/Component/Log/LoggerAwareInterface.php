<?php

namespace Xand\Component\Log;

/**
 * Interface LoggerAwareInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface LoggerAwareInterface
{
    /**
     * @param LoggerInterface   $logger
     */
    public function setLogger(LoggerInterface $logger);

    /**
     * @return LoggerInterface
     */
    public function getLogger();
}