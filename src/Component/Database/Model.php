<?php

namespace Xand\Component\Database;
use RedBeanPHP\SimpleModel;
use Xand\Component\Log\LoggerAwareInterface;
use Xand\Component\Log\LoggerInterface;

/**
 * Class Model
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Model extends SimpleModel implements LoggerAwareInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param \Xand\Component\Log\LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return \Xand\Component\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
}