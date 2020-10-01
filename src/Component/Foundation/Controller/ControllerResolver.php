<?php

namespace Xand\Component\Foundation\Controller;
use Xand\Component\Foundation\ServerRequest;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ControllerResolver implements ControllerResolverInterface
{
    /**
     * @param \Xand\Component\Foundation\ServerRequest $request
     *
     * @return array
     * @throws \ReflectionException
     */
    public function getController(ServerRequest $request)
    {
        if (null === ($controller = $request->getAttribute('_controller')))
            throw new \InvalidArgumentException();

		if (false === ($pos = strpos($controller, '::')))
			throw new \Exception();
		
		$class 	= substr($controller, 0, $pos);
		$method	= substr($controller, $pos + 2);
		$reflector = new \ReflectionClass ($class);
		if ($reflector->isAbstract())
			throw new \Exception();
		
		/* @var object */
		$object = $this->resolveController($reflector);
		
		$reflector = new \ReflectionMethod($class, $method);
		if ($reflector->isAbstract() || !$reflector->isPublic())
			throw new \Exception();
		
		return [
			$object,
			$method
		];
		
    }
	
	/**
	 * @param \ReflectionClass	$reflector
	 * 
	 * @return object
	 */
	public function resolveController(\ReflectionClass $reflector)
	{
		return $reflector->newInstance();
	}
}