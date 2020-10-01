<?php

namespace Xand\Component\EventDispatcher;

/**
 * Class Event
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Event
{
    /**
     * @var bool
     */
    protected $propagationStopped = false;
	
    /**
     * @return static
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }
}