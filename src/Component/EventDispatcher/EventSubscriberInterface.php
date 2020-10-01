<?php

namespace Xand\Component\EventDispatcher;

/**
 * Interface EventSubscriberInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface EventSubscriberInterface
{
    /**
     * @return array
     */
    public function getEventListeners();
}