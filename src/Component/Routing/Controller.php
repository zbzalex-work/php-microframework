<?php

namespace Xand\Component\Routing;

/**
 * Class Controller
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Controller
{
    /**
     * @var \Xand\Component\Routing\Route
     */
    protected $route;

    /**
     * Controller constructor.
     *
     * @param \Xand\Component\Routing\Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    /**
     * @return \Xand\Component\Routing\Route
     */
    public function getRoute()
    {
        return $this->route;
    }
}