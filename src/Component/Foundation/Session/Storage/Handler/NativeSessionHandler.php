<?php

namespace Xand\Component\Foundation\Session\Storage\Handler;

/**
 * Class NativeSessionHandler
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class NativeSessionHandler implements \SessionHandlerInterface
{
	/**
	 * @var string
	 */
	protected $savePath;
	
	/**
	 * @var string
	 */
	protected $prefix;
	
	/**
	 * @param string $prefix
	 */
	public function __construct($prefix = null)
	{
		$this->prefix = null === $prefix ? 'PHPSESSIONID' : $prefix;
	}
	
	/**
	 * @param string    $prefix
	 * 
	 * @return static
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}
	
	/**
	 * @param string $savePath
	 * @param string $name
	 * 
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 * 
	 * @return void
	 */
	public function open($savePath, $name)
	{
		if (!is_dir($savePath))
			throw new \InvalidArgumentException();
		
		if (!mkdir($savePath))
			throw new \RuntimeException();
		
		$this->savePath = $savePath;
	}
	
	/**
	 * @return bool
	 */
	public function close()
	{
		return true;
	}
	
	/**
	 * @param int $maxlifetime
	 * 
	 * @throw RuntimeException
	 * 
	 * @return void
	 */
	public function gc($maxlifetime)
	{
		if (false === ($h = opendir($this->savePath)))
			throw new \RuntimeException();
		
		while($filename = readdir($h)) {
			if ('.' == $filename || '..' == $filename) continue;
			if ($this->prefix != substr($filename, 0, strlen($this->prefix))) continue;
			$relPath = $this->savePath . '/' . $filename;
			if (filemtime($relPath) + $maxlifetime > time()) continue;
			if (!unlink($relPath))
				throw new \RuntimeException();
		}
	}
	
	/**
	 * @param string $id
	 * 
	 * @throws \RuntimeException
	 * 
	 * @return string
	 */
	public function read($id)
	{
		$relPath = $this->savePath . '/' . $this->prefix . $id;
		
		if (!is_file($relPath))
			throw new \RuntimeException();
		
		if (!is_readable($relPath))
			throw new \RuntimeException();
		
		if (!($contents = file_get_contents($relPath)))
			throw new \RuntimeException();
		
		return $contents;
	}
	
	/**
	 * @param string $id
	 * @param string $data
	 * 
	 * @throws RuntimeException
	 * 
	 * @return bool
	 */
	public function write($id, $data)
	{
		if (!file_put_contents($this->savePath . '/' . $this->prefix . $id, $data))
			throw new \RuntimeException();
		
		return true;
	}
	
	/**
	 * @retur bool
	 */
	public function destroy()
	{
		/* @var resource */
		if (false === ($h = opendir($this->savePath)))
			throw new \RuntimeException();
		
		while($filename = readdir($h)) {
			if ('.' == $filename || '..' == $filename) continue;
			if ($this->prefix != substr($filename, 0, strlen($this->prefix))) continue;
			
			if (!unlink($this->savePath . '/' . $filename))
				throw new \RuntimeException();
		}
		
		return true;
	}
}