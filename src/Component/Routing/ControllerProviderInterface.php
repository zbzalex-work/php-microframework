<?php

namespace Xand\Component\Routing;

/**
 * Interface ControllerProvider
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ControllerProviderInterface
{
    /**
     * @return \Xand\Component\Routing\ControllerCollection
     */
    public function connect();
}