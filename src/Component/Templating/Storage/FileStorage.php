<?php

namespace Xand\Component\Templating\Storage;

/**
 * Class FileStorage
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FileStorage implements StorageInterface
{
	/**
	 * @var string $path
	 */
	protected $path;
	
	/**
	 * @param string $path
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}
	
	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->path;
	}
}