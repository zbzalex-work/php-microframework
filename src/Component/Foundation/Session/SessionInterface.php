<?php

namespace Xand\Component\Foundation\Session;

/**
 * Interface SessionInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface SessionInterface
{
	/**
	 * @return mixed
	 */
	public function start();

	/**
	 * @return bool
	 */
	public function isStarted();
	
	/**
	 * @return string
	 */
	public function getId();
	
	/**
	 * @param bool $removePrevSession
	 * 
	 * @return string
	 */
	public function refresh($removePrevSession = false);
	
	/**
	 * @param string $id
	 * 
	 * @return mixed
	 */
	public function setId($id);
	
	/**
	 * @param string $name
	 * 
	 * @return mixed
	 */
	public function setName($name);

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @param string $key
	 * 
	 * @return mixed
	 */
	public function has($key);

    /**
     * @param string    $key
     * @param null      $default
     *
     * @return mixed
     */
	public function get($key, $default = null);

	/**
	 * @param string $key
	 * @param string $value
	 * 
	 * @return mixed
	 */
	public function set($key, $value);

	/**
	 * @param string $key
	 * 
	 * @return mixed
	 */
	public function remove($key);

	/**
	 * @return mixed
	 */
	public function close();
	
	/**
	 * @return mixed
	 */
	public function removeAll();
	
	/**
	 * @return array
	 */
	public function all();
}