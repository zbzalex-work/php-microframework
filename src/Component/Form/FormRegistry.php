<?php

namespace Xand\Component\Form;

/**
 * Class FormRegistry
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormRegistry implements FormRegistryInterface
{
	/**
	 *	@var TypeInterface[]
	 */
	protected $resolvedTypes = [];

    /**
     * FormRegistry constructor.
     */
	public function __construct()
	{
		$this->resolvedTypes = [];
	}

    /**
     * @param string $class
     *
     * @return mixed|\Xand\Component\Form\TypeInterface
     * @throws \ReflectionException
     */
	public function getType($class)
	{
		if (!isset($this->resolvedTypes[$class])) {
		    $this->resolvedTypes[$class] = $this->resolveType($class);
        }
		
		return $this->resolvedTypes[$class];
	}

    /**
     * @param string $class
     *
     * @return object
     * @throws \ReflectionException
     * @throws \Exception
     */
	public function resolveType($class)
	{
		$reflector = new \ReflectionClass($class);

		if ($reflector->isAbstract()) {
            throw new \Exception();
        }
		
		$instance = $reflector->newInstance();

		if (!$instance instanceof TypeInterface) {
            throw new \Exception();
        }
		
		return $instance;
	}
	
	/**
	 * @return static
	 */
	public function clear()
	{
		$this->resolvedTypes = [];
		
		return $this;
	}
}