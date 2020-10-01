<?php

namespace Xand\Component\Templating;

/**
 * Class Template
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Template
{
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var string
	 */
	protected $engine;
	
	/**
	 * @param string $name
	 * @param string $engine
	 */
	public function __construct($name, $engine)
	{
		$this->name = $name;
		$this->engine = $engine;
	}
	
	/**
	 * @param string $name
	 * 
	 * @return static
	 */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param string $engine
	 * 
	 * @return static
	 */
	public function setEngine($engine)
	{
		$this->engine = $engine;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getEngine()
	{
		return $this->engine;
	}
}