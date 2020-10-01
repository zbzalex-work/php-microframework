<?php

namespace Xand\Component\Templating\Loader;

/**
 * Interface LoaderInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface LoaderInterface
{
	/**
	 * @param string $filename
	 */
    public function load($filename);
}