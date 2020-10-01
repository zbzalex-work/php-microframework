<?php

namespace Xand\Component\DependencyInjection\Extension;
use Xand\Component\DependencyInjection\ContainerBuilder;

/**
 * Interface ExtensionInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ExtensionInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param ContainerBuilder  $container
     */
    public function load(ContainerBuilder $container);
}