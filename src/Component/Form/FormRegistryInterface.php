<?php

namespace Xand\Component\Form;

/**
 * Interface FormRegistryInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface FormRegistryInterface
{
	/**
	 * @param string $class
	 * 
	 * @return TypeInterface
	 */
	public function getType($class);
	
	/**
	 * @param string $class
	 */
	public function resolveType($class);
	
	/**
	 * @return static
	 */
	public function clear();
}