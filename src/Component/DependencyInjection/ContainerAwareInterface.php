<?php

namespace Xand\Component\DependencyInjection;

/**
 * Interface ContainerAwareInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ContainerAwareInterface
{
    /**
     * @return ContainerInterface
     */
    public function getContainer();

    /**
     * @param ContainerInterface $container
	 * 
	 * @return mixed
     */
    public function setContainer(ContainerInterface $container);
}