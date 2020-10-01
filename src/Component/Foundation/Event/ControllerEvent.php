<?php

namespace Xand\Component\Foundation\Event;

/**
 * Class ControllerEvent
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ControllerEvent extends RequestEvent
{
	/**
	 * @var object
	 */
	protected $controller;
	
	/**
	 * @return object
	 */
	public function getController()
	{
		return $this->controller;
	}
	
	/**
	 * @param object	$controller
	 * 
	 * @return static
	 */
	public function setController($controller)
	{
		$this->controller = $controller;
		
		return $this;
	}
}