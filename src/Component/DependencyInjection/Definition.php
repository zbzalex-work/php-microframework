<?php

namespace Xand\Component\DependencyInjection;

/**
 * Class Definition
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Definition
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var array
     */
    protected $calls;

    /**
     * @var bool
     */
    protected $deprecated = false;

    /**
     * @var string
     */
    protected $deprecationMessage;

    /**
     * @var
     */
    protected $factory;

    /**
     * Definition constructor.
     *
     * @param string    $class
     * @param string[]  $arguments
     * @param array     $calls
     */
    public function __construct($class, array $arguments = [], array $calls = [])
    {
        $this->class = $class;
        $this->arguments = $arguments;
        $this->calls = [];
        $this->properties = [];
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string    $class
     *
     * @return static
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param string    $value
     *
     * @return static
     */
    public function addArgument($value)
    {
        $this->arguments[] = $value;

        return $this;
    }

    /**
     * @param int       $offset
     * @param string    $value
     *
     * @return static
     */
    public function replaceArgument($offset, $value)
    {
        if (isset($this->arguments[ $offset ]))
                  $this->arguments[ $offset ] = $value;

        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param string    $method
     * @param array     $arguments
     *
     * @return $this
     */
    public function addMethodCall($method, array $arguments = [])
    {
        $this->calls[ $method ] = $arguments;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethodCalls()
    {
        return $this->calls;
    }

    /**
     * @param bool $deprecated
     *
     * @return static
     */
    public function setDeprecated($deprecated = true)
    {
        $this->deprecated = (bool)$deprecated;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeprecated()
    {
        return $this->deprecated;
    }

    /**
     * @param string $message
     *
     * @return static
     */
    public function setDeprecationMessage($message)
    {
        $this->deprecationMessage = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeprecationMessage()
    {
        return $this->deprecationMessage;
    }

    /**
     * @param callable  $factory
     *
     * @return static
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @return callable|string|array
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param string    $property
     * @param string    $value
     *
     * @return static
     */
    public function setProperty($property, $value)
    {
        $this->properties[ $property ] = $value;

        return $this;
    }

    /**
     * @param string    $property
     *
     * @return mixed|null
     */
    public function getProperty($property)
    {
        return isset($this->properties[ $property ]) ? $this->properties[ $property ] : null;
    }

    /**
     * @param string    $property
     *
     * @return static
     */
    public function removeProperty($property)
    {
        if (isset($this->properties[ $property ])) {
            unset($this->properties[ $property ]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}