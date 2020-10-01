<?php

namespace Xand\Component\DependencyInjection;

/**
 * Class ContainerAware
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ContainerAware implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     * 
     * @return static
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }
}