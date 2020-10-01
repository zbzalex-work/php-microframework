<?php

namespace Xand\Component\Templating;

/**
 * Class TemplateNameParser
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class TemplateNameParser implements TemplateNameParserInterface
{
	/**
	 * @param string $name
	 * 
	 * @return Template
	 */
	public function parse($name)
	{
		$engine = false !== ($pos = \strrpos($name, ".")) ? \substr($name, $pos + 1) : null;
		
		return new Template($name, $engine);
	}
}