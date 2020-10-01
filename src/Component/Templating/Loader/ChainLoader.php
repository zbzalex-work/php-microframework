<?php

namespace Xand\Component\Templating\Loader;

/**
 * Class ChainLoader
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ChainLoader implements LoaderInterface
{
	/**
	 *	@var \Xand\Component\Templating\Loader\LoaderInterface[]
	 */
	protected $loaders = [];
	
	/**
	 * @param LoaderInterface[] $loaders
	 */
	public function __construct(array $loaders = [])
	{
		foreach($loaders as $loader) {
		    $this->addLoader($loader);
        }
	}
	
	/**
	 * @param LoaderInterface $loader
	 * 
	 * @return static
	 */
	public function addLoader(LoaderInterface $loader)
	{
		$this->loaders[] = $loader;
		
		return $this;
	}
	
	/**
	 * @param string $filename
	 * 
	 * @return mixed
	 */
	public function load($filename)
	{
		foreach($this->loaders as $loader) {
			if (null !== ($storage = $loader->load($filename))) {
				return $storage;
			}
		}
	}
}