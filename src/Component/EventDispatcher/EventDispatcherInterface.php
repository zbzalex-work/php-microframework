<?php

namespace Xand\Component\EventDispatcher;

/**
 * Interface EventDispatcherInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface EventDispatcherInterface
{
    /**
     * @param                                            $event_name
     * @param \Xand\Component\EventDispatcher\Event|null $event
     *
     * @return mixed
     */
    public function dispatch($event_name, Event $event = null);
}