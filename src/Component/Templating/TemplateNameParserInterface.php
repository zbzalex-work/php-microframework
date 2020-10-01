<?php

namespace Xand\Component\Templating;

/**
 * Interface TemplateNameParserInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface TemplateNameParserInterface
{
	/**
	 * @param string $name
	 */
	public function parse($name);
}