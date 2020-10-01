<?php

namespace Xand\Component\Routing;

/**
 * Class Mount
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ControllerCollection
{
    /**
     * @var null|string
     */
    protected $prefix;

    /**
     * @var Controller[]|\Xand\Component\Routing\ControllerCollection[]
     */
    protected $controllers;

    /**
     * ControllerCollection constructor.
     *
     * @param null|string $prefix
     */
    public function __construct($prefix = null)
    {
        $this->prefix = $prefix;
        $this->controllers = [];
    }

    /**
     * @param string $prefix
     *
     * @return static
     */
    public function setPrefix($prefix) {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $path
     * @param string $to
     *
     * @return \Xand\Component\Routing\Controller
     */
    public function match($path, $to)
    {
        $route = new Route();
        $route->setPath($path);
        $route->setAttribute("_controller", $to);

        $controller = new Controller($route);
        $this->controllers[] = $controller;

        return $controller;
    }

    /**
     * @param                                              $prefix
     * @param \Xand\Component\Routing\ControllerCollection $controllers
     *
     * @return $this
     */
    public function mount($prefix, ControllerCollection $controllers)
    {
        $this->controllers[] = $controllers;
        $controllers->setPrefix($prefix);

        return $this;
    }

    /**
     * @param null                                         $prefix
     * @param \Xand\Component\Routing\RouteCollection|null $routes
     *
     * @return \Xand\Component\Routing\RouteCollection
     */
    public function flush($prefix = null, RouteCollection $routes = null)
    {
        $prefix = null !== $prefix ? "/" . \trim($prefix, "/") : "";
        $routes = null !== $routes ? $routes : new RouteCollection();

        foreach($this->controllers as $controller) {
            if ($controller instanceof Controller) {
                $route = $controller->getRoute();
                $route->setPath($prefix . $route->getPath());
                $routes->add($route);
            } else {
                $controller->flush($prefix . $controller->getPrefix(), $routes);
            }
        }

        return $routes;
    }
}