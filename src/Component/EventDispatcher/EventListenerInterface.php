<?php

namespace Xand\Component\EventDispatcher;

/**
 * Interface EventListenerInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface EventListenerInterface
{
    /**
     * @param $event
     *
     * @return mixed
     */
    public function __invoke($event);
}