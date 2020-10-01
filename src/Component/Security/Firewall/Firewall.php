<?php

namespace Xand\Component\Security\Firewall;
use Xand\Component\Foundation\RequestMatcher;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Firewall
{
	/**
	 * @var array
	 */
	protected $map;

    /**
     * Firewall constructor.
     */
	public function __construct()
    {
        $this->map = [];
    }
	
	/**
	 * @param RequestMatcher	$matcher
	 * @param callable[]		$listeners
	 * 
	 * @return static
	 */
	public function add(RequestMatcher $matcher, array $listeners)
	{
		$this->map[] = new Guard($matcher, $listeners);
		
		return $this;
	}
	
	/**
	 * @param Event	$event
	 * 
	 * @return void
	 */
	public function onKernelRequest($event)
	{
		foreach($this->map as $guard) {
			if (!$guard->getRequestMatcher()->match($event->getRequest()))
				continue;
			
			foreach($guard->getEventListeners() as $listener) {
				\call_user_func($listener, $event);
			}
		}
	}
}