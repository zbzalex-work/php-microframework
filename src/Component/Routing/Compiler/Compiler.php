<?php

namespace Xand\Component\Routing\Compiler;

/**
 * Class Compiler
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Compiler implements CompilerInterface
{
	/**
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function compile($path)
	{
		$path = \preg_replace_callback("/\:(\w+)/", function($matches) {
			return \is_numeric(substr($matches[1], 0, 1))
				|| \is_numeric($matches[1]) ? "" : "(?P<" . $matches[1] . ">[^\/$]+)";
		}, \str_replace("/", "\/", $path));
		
		if ("/" != \substr($path, -1))
			$path .= "\/";
		
		if ("/" == \substr($path, -1))
			$path .= "?";
		
		return $path;
	}
}