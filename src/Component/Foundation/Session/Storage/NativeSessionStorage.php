<?php

namespace Xand\Component\Foundation\Session\Storage;
use Xand\Component\Foundation\Session\Storage\Handler\NativeSessionHandler;

/**
 * Class NativeSessionStorage
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class NativeSessionStorage implements StorageInterface
{
	/**
	 * @var bool
	 */
	protected $started = false;
	
	/**
	 * @var \SessionHandlerInterface
	 */
	protected $handler;
	
	/**
	 * @param \SessionHandlerInterface $handler
	 * @param string $savePath
	 */
	public function __construct(\SessionHandlerInterface $handler = null, $savePath = null)
	{
		ini_set('session.use_cookie', true);
		if (null !== $savePath) ini_set('session.save_path', $savePath);
	
		session_register_shutdown();
		
		$this->setSaveHandler(null === $handler ? new \SessionHandler() : $handler);
	}

	/**
	 * @param \SessionHandlerInterface $handler
	 * 
	 * @throws \RuntimeException
	 * 
	 * @return static
	 */
	public function setSaveHandler(\SessionHandlerInterface $handler)
	{
		if (PHP_SESSION_ACTIVE == \session_status() || \headers_sent())
			throw new \RuntimeException();
		
		$this->handler = $handler;
		\session_set_save_handler($handler, true);
		
		return $this;
	}

    /**
     * @return static
     * @throws \Exception
     */
	public function start()
	{
		if ($this->started)
			return true;
		
		if (PHP_SESSION_ACTIVE == \session_status() || \headers_sent() || !\session_start())
			throw new \Exception();
		
		$this->started = true;
		
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isStarted()
	{
		return $this->started;
	}
	
	/**
	 * @return static
	 */
	public function close()
	{
		session_destroy();
		
		return $this;
	}
	
	/**
	 * @param string $name
	 * 
	 * @return static
	 */
	public function setName($name)
	{
		session_name($name);
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return session_name();
	}
	
	/**
	 * @param string $id
	 * 
	 * @return static
	 */
	public function setId($id)
	{
		session_id($id);
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getId()
	{
		return session_id();
	}
	
	/**
	 * @param bool $removePrevSession
	 * 
	 * @return string
	 */
	public function refresh($removePrevSession = false)
	{
		if (!PHP_SESSION_ACTIVE != session_status())
			return false;
		
		if (headers_sent())
			return false;
		
		session_regenerate_id($removePrevSession);
		
		return $this->getId();
	}
	
	/**
	 * @param string $key
	 * 
	 * @return bool
	 */
	public function has($key)
	{
		return isset($_SESSION[$key]);
	}
	
	/**
	 * @param string $key
	 * 
	 * @return string
	 */
	public function get($key, $default = null)
	{
		return $this->has($key) ? $_SESSION[$key] : $default;
	}
	
	/**
	 * @param string $key
	 * @param string $value
	 * 
	 * @return static
	 */
	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
		
		return $this;
	}
	
	/**
	 * @param string $key
	 * 
	 * @return static
	 */
	public function remove($key)
	{
		if ($this->has($key)) unset($_SESSION[$key]);
		
		return $this;
	}
	
	/**
	 * @return static
	 */
	public function removeAll()
	{
		$_SESSION = [];
		
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function all()
	{
		return $_SESSION;
	}
}