<?php

namespace Xand\Component\Routing;

/**
 * Class Router
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Router
{
    /**
     * @var \Xand\Component\Routing\RouteCollection
     */
    protected $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    /**
     * @param                                                     $prefix
     * @param \Xand\Component\Routing\ControllerProviderInterface $controllerProvider
     *
     * @return $this
     * @throws \Exception
     */
    public function mount($prefix, ControllerProviderInterface $controllerProvider)
    {
        $controllers = $controllerProvider->connect();
        if (!($controllers instanceof ControllerCollection))
            throw new \Exception("Expect ControllerCollection object");

        $controllers->flush($prefix, $this->routes);

        return $this;
    }

    /**
     * @return \Xand\Component\Routing\RouteCollection
     */
    public function getRouteCollection()
    {
        return $this->routes;
    }
}