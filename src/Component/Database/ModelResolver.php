<?php

namespace Xand\Component\Database;
use Xand\Component\Log\LoggerInterface;

/**
 * Class ModelResolver
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ModelResolver
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * ModelResolver constructor.
     *
     * @param LoggerInterface|null $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $class
     *
     * @return object
     */
    public function resolve($class)
    {
        /** @var Model $model */
        $model = new $class();

        if (null !== $this->logger) {
            $model->setLogger($this->logger);
        }

        return $model;
    }
}