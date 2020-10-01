<?php

namespace Xand\Component\Routing;

/**
 * Class RouteCollection
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class RouteCollection
{
	/**
	 * @var RouteInterface[]
	 */
	protected $routes;

    /**
     * RouteCollection constructor.
     */
	public function __construct()
	{
		$this->routes = [];
	}

    /**
     * @return \ArrayIterator
     */
	public function iterator()
	{
		return new \ArrayIterator($this->routes);
	}

    /**
     * @return \ArrayIterator
     */
	public function flush()
    {
        $it = $this->iterator();
        $this->routes = [];

        return $it;
    }

	/**
	 * @param RouteInterface|RouteCollection $route
	 * 
	 * @return static
	 */
	public function add($route)
	{
	    if ($route instanceof RouteInterface) {
			$this->routes[] = $route;
		} else if ($route instanceof RouteCollection) {
			$it = $route->iterator();
			foreach($it as $route) {
				$this->add($route);
			}
		}
		
		return $this;
	}
}

