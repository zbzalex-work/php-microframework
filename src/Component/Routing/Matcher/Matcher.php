<?php

namespace Xand\Component\Routing\Matcher;
use Xand\Component\Routing\RouteCollection;
use Xand\Component\Foundation\ServerRequest;
use Xand\Component\Routing\Compiler\Compiler;
use Xand\Component\Routing\Util\ArrayUtil;

/**
 * Class Matcher
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Matcher implements MatcherInterface
{
	/**
	 * @var RouteCollection
	 */
	protected $routes;

    /**
     * Matcher constructor.
     *
     * @param \Xand\Component\Routing\RouteCollection $map
     */
	public function __construct(RouteCollection $map)
	{
		$this->routes = $map;
	}
	
	/**
	 * @param ServerRequest $request
	 * 
	 * @return static
	 */
	public function match(ServerRequest $request)
	{
		foreach($this->routes->flush() as $route) {

			if (!$route->hasScheme($request->getUri()->getScheme()) && !$route->hasMethod($request->getMethod())
                && !$route->hasMethod('*'))
				continue;
			
			/* @var string $path */
			$path = Compiler::compile($route->getPath());
			
			if (!preg_match('/^' . $path . '$/i', $request->getUri()->getPath(), $matches))
				continue;

			$attributes = \array_map("urldecode", ArrayUtil::toAssocArray($matches));
			$route->addAttributes($attributes);

			$request->setAttributes($route->getAttributes());
			$request->setAttribute("_route", $route);
			
			break;
			
		}
		
		return $this;
	}
}