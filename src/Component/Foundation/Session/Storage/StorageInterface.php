<?php

namespace Xand\Component\Foundation\Session\Storage;

/**
 * Interface StorageInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface StorageInterface
{
	/**
	 * @param \SessionHandlerInterface $handler
	 */
	public function setSaveHandler(\SessionHandlerInterface $handler);
	
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
	public function getName();
	
	/**
	 * @param string $name
	 */
	public function setName($name);
	
	/**
	 * @param string $id
	 */
	public function setId($id);
	
	/**
	 * @return string
	 */
	public function getId();
	
	/**
	 * @return string
	 */
	public function refresh();
	
	/**
	 * @return bool
	 */
	public function has($key);

	/**
	 * @param string $key
	 */
	public function get($key);
	
	/**
	 * @param string $key
	 * @param string $val
	 */
	public function set($key, $val);
	
	/**
	 * @param string $key
	 */
	public function remove($key);
	
	/**
	 * @return mixed
	 */
	public function removeAll();
}