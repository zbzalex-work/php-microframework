<?php

namespace Xand\Component\Foundation\Session;
use Xand\Component\Foundation\Session\Storage\SessionStorageInterface;
use Xand\Component\Foundation\Session\Storage\NativeSessionStorage;

/**
 * Class Session
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Session implements SessionInterface, \ArrayAccess
{
	/**
	 * @var SessionStorageInterface
	 */
	protected $storage;
	
	/**
	 * @param SessionStorageInterface	$storage
	 */
	public function __construct(SessionStorageInterface $storage = null)
	{
		$this->storage = null === $storage ? new NativeSessionStorage() : $storage;
	}

    /**
     * @return $this|mixed
     * @throws \Exception
     */
	public function start()
	{
		$this->storage->start();
		
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isStarted()
	{
		return $this->storage->isStarted();
	}
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->storage->getId();
	}
	
	/**
	 * @param int	$id
	 * 
	 * @return static
	 */
	public function setId($id)
	{
		$this->storage->setId($id);
		
		return $this;
	}

	/**
	 * @param bool	$removePrevSession
	 * 
	 * @return string
	 */
	public function refresh($removePrevSession = false)
	{
		return $this->storage->refresh($removePrevSession);
	}

    /**
     * @param string $name
     *
     * @return static
     */
	public function setName($name)
	{
		$this->storage->setName($name);
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->storage->getName();
	}
	
	/**
	 * @return static
	 */
	public function close()
	{
		$this->storage->close();
		
		return $this;
	}
	
	/**
	 * @param string	$key
	 * 
	 * @return bool
	 */
	public function has($key)
	{
		return $this->storage->has($key);
	}

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed|string
     */
	public function get($key, $default = null)
	{
		return $this->storage->get($key, $default);
	}
	
	/**
	 * @param string	$key
	 * @param string	$value
	 * 
	 * @return static
	 */
	public function set($key, $value)
	{
		$this->storage->set($key, $value);
		
		return $this;
	}
	
	/**
	 * @param string 	$key
	 * 
	 * @return static
	 */
	public function remove($key)
	{
		$this->storage->remove($key);
		
		return $this;
	}
	
	/**
	 * @param string	$key
	 * 
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return $this->has($key);
	}
	
	/**
	 * @param string	$key
	 * 
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}
	
	/**
	 * @param string 	$key
	 * @param string	$value
	 */
	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}
	
	/**
	 * @param string	$key
	 */
	public function offsetUnset($key)
	{
		$this->remove($key);
	}
	
	/**
	 * @return static
	 */
	public function removeAll()
	{
		$this->storage->removeAll();
		
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function all()
	{
		return $this->storage->all();
	}
}