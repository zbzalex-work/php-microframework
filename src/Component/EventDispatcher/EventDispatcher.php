<?php

namespace Xand\Component\EventDispatcher;

/**
 * Class EventDispatcher
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array
     */
    protected $listeners;

    /**
     * EventDispatcher constructor.
     */
    public function __construct()
    {
        $this->listeners = [];
    }

    /**
     * @param string	$name
     * 
     * @return bool
     */
    public function hasListeners($name)
    {
        return isset($this->listeners[$name]);
    }

    /**
     * @param string	$name
     * 
     * @return array|false
     */
    public function getListeners($name)
    {
        return $this->hasListeners($name) ? $this->listeners[$name] : false;
    }

    /**
     * @param     $name
     * @param     $listener
     * @param int $priority
     *
     * @return static
     */
    public function addEventListener($name, $listener, $priority = 0)
    {
        if (!isset($this->listeners[$name][$priority])) {
            $this->listeners[$name][$priority] = [];
        }
		
        $this->listeners[$name][$priority][] = $listener;

        return $this;
    }

    /**
     * @param \Xand\Component\EventDispatcher\EventSubscriberInterface $subscriber
     *
     * @return static
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach($subscriber->getEventListeners() as $name => $method) {
			$this->addEventListener($name,[
			    $subscriber,
                $method
            ]);
		}
		
        return $this;
    }
	
    /**
     * @param string	$name
     * @param Event		$event
     * 
     * @return static
     */
    public function dispatch($name, Event $event = null)
    {
        if (($listeners = $this->getListeners($name))) {

            $event = null === $event ? new Event() : $event;

            \krsort($listeners);

            foreach($listeners as $priority => $collection) {
                foreach($collection as $listener) {

                    if ($event->isPropagationStopped())
                        break;

                    $listener($event);

                }

            }
        }
		
        return $this;
    }
}