<?php

namespace Xand\Component\Security\Firewall;
use Xand\Component\Foundation\RequestMatcher;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Guard
{
	/**
	 * @var RequestMatcher
	 */
	protected $matcher;
	
	/**
	 * @var callable[]
	 */
	protected $listeners;
	
	/**
	 * @param RequestMatcher	$matcher
	 * @param callable[]		$listeners
	 */
	public function __construct(RequestMatcher $matcher = null, array $listeners = [])
	{
		$this->matcher = $matcher;
		$this->listeners = [];
		foreach($listeners as $listener)
			$this->addEventListener($listener);
	}
	
	/**
	 * @param RequestMatcher	$matcher
	 * 
	 * @return static
	 */
	public function setRequestMatcher(RequestMatcher $matcher)
	{
		$this->matcher = $matcher;
		
		return $this;
	}
	
	/**
	 * @return RequestMatcher
	 */
	public function getRequestMatcher()
	{
		return $this->matcher;
	}
	
	/**
	 * @param callable	$callable
	 * 
	 * @return static
	 */
	public function addEventListener($callable)
	{
		$this->listeners[] = $callable;
		
		return $this;
	}
	
	/**
	 * @return callable[]
	 */
	public function getEventListeners()
	{
		return $this->listeners;
	}
}