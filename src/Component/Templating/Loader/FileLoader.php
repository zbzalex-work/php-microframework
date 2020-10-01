<?php

namespace Xand\Component\Templating\Loader;
use Xand\Component\Filesystem\FileLocator;
use Xand\Component\Templating\Storage\FileStorage;

/**
 * Class FileLoader
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FileLoader implements LoaderInterface
{
	/**
	 * @var FileLocator
	 */
	protected $locator;

	/**
	 * @param FileLocator $locator
	 */
	public function __construct(FileLocator $locator)
	{
		$this->locator = $locator;
	}
	
	/**
	 * @param string $filename
	 * 
	 * @return mixed
	 */
	public function load($filename)
	{
		try
		{
		    $path = $this->locator->locate($filename, null, 1);

            if (!\is_file($path))
                throw new \Exception();

            return new FileStorage($path);
		} catch(\Exception $e) {}
	}
}