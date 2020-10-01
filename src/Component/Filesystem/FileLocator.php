<?php

namespace Xand\Component\Filesystem;
use Xand\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class FileLocator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FileLocator
{
	/**
	 * @var string[]
	 */
	protected $paths;

    /**
     * FileLocator constructor.
     *
     * @param string[] $paths
     */
	public function __construct(array $paths = [])
	{
		$this->paths = $paths;
	}

    /**
     * @param      $filename
     * @param null $path
     * @param bool $first
     *
     * @return array|string
     * @throws \Xand\Component\Filesystem\Exception\FileNotFoundException
     */
	public function locate($filename, $path = null, $first = false)
	{
		if ($this->isAbsolutePath($filename)) {
			if ( ! file_exists($filename))
				throw new FileNotFoundException();
			
			return $filename;
		}
		
		/* @var string[] */
		$paths = $this->paths;
		if (null !== $path)
			array_unshift($paths, $path);
		
		$paths = array_unique($paths);
		$results = [];
		foreach($paths as $path) {
			$_path = $path . '/' . $filename;
			if (file_exists($_path)) {
			
				if ($first)
					return $_path;
			
				$results[] = $_path;
			}
		}
		
		if ( ! $results)
			throw new FileNotFoundException();
		
		return $results;
	}
	
	/**
	 * @param string $path
	 * 
	 * @return bool
	 */
	public function isAbsolutePath($path)
	{
		return ('/' == substr($path, 0, 1) || '\\' == substr($path, 0, 1))
			 && ':' == substr($path, 1, 1)
			 &&('/' == substr($path, 2, 1) || '\\' == substr($path, 2, 1));
	}
}