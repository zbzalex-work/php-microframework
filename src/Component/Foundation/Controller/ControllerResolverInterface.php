<?php

namespace Xand\Component\Foundation\Controller;
use Xand\Component\Foundation\ServerRequest;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ControllerResolverInterface
{
    /**
     * @param ServerRequest	$request
     * 
     * @return array
     */
    public function getController(ServerRequest $request);
	
	/**
	 * @param \ReflectionClass	$reflector
	 * 
	 * @return object
	 */
	public function resolveController(\ReflectionClass $reflector);
}