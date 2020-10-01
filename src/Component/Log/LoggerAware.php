<?php

namespace Xand\Component\Log;

/**
 * Class LoggerAware
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class LoggerAware
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * 
     * @return static
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }
}