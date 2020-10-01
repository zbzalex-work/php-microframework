<?php

namespace Xand\Component\Routing;

/**
 * Interface RouteInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface RouteInterface
{
	/**
	 * @return string[]
	 */
	public function getSchemes();
	
	/**
	 * @param string $scheme
	 */
	public function addScheme($scheme);


	/**
	 * @return string[]
	 */
	public function getMethods();
	
	/**
	 * @param string $method
	 */
	public function addMethod($method);
	
	/**
	 * @return string
	 */
	public function getPath();
	
	/**
	 * @param string $path
	 * 
	 * @return mixed
	 */
	public function setPath($path);
	
	/**
	 * @param string $key
	 * 
	 * @return bool
	 */
	public function hasAttribute($key);

	/**
	 * @param string $key
     * @param string $value
	 * 
	 * @return mixed
	 */
	public function setAttribute($key, $value);
	
	/**
	 * @param string $key
	 * 
	 * @return mixed
	 */
	public function getAttribute($key);
	
	/**
	 * @return array
	 */
	public function getAttributes();

    /**
     * @param array $attributes
     */
	public function setAttributes(array $attributes);

    /**
     * @param array $attributes
     */
	public function addAttributes(array $attributes);
	
	/**
	 * @param string $key
	 */
	public function removeAttribute($key);
}