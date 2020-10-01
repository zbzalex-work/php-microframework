<?php

namespace Xand\Component\Templating;

/**
 * Interface EngineInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface EngineInterface
{
	/**
	 * @param string $name
	 * @param array $parameters
	 * 
	 * @return mixed
	 */
	public function render($name, array $parameters = []);
	
	/**
	 * @param Template $template
	 * 
	 * @return bool
	 */
	public function supports(Template $template);
}