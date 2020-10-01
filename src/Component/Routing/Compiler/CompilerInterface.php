<?php

namespace Xand\Component\Routing\Compiler;

/**
 * Interface CompilerInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface CompilerInterface
{
	/**
	 * @param string $path
	 * 
	 * @return string
	 */
    public static function compile($path);
}