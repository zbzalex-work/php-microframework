<?php

namespace Xand\Component\DependencyInjection;

/**
 * Class Reference
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Reference
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Reference constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}