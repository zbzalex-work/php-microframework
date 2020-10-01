<?php

namespace Xand\Component\DependencyInjection;
use Xand\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class ContainerBuilder
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ContainerBuilder extends Container
{
    /**
     * @var Definition[]
     */
    protected $definitions;

    /**
     * @var ExtensionInterface[]
     */
    protected $extensions;

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * ContainerBuilder constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->definitions = [];
        $this->extensions = [];
    }

    /**
     * @param string $name
     * @param string $class
     *
     * @return Definition
     */
    public function register($name, $class)
    {
        $definition = new Definition($class);
        $this->definitions[ $name ] = $definition;

        return $definition;
    }

    /**
     * @param \Xand\Component\DependencyInjection\Extension\ExtensionInterface $extension
     *
     * @return static
     */
    public function registerExtension(ExtensionInterface $extension)
    {
        $this->extensions[ $extension->getName() ] = $extension;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function loadFromExtension($name)
    {
        if (isset($this->extensions[$name]))
            $this->extensions[$name]->load($this);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed|null|\Xand\Component\DependencyInjection\Extension\ExtensionInterface
     */
    public function getExtension($name)
    {
        return isset($this->extensions[$name]) ? $this->extensions[$name] : null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasExtension($name)
    {
        return isset($this->extensions[ $name ]);
    }

    /**
     * @return array|\Xand\Component\DependencyInjection\Extension\ExtensionInterface[]
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @param $name
     *
     * @return mixed|null|\Xand\Component\DependencyInjection\Definition
     */
    public function getDefinition($name)
    {
        return isset($this->definitions[ $name ]) ? $this->definitions[ $name ] : null;
    }

    /**
     * @param string $id
     * @param string $service
     *
     * @return static|\Xand\Component\DependencyInjection\Container
     */
    public function set($id, $service)
    {
        parent::set($id, $service);

        if (isset($this->definitions[$id])) {
            unset($this->definitions[$id]);
        }

        return $this;
    }

    /**
     * @param string $id
     * @param int    $invalidBehavior
     *
     * @return mixed|null|string
     * @throws \Exception
     */
    public function get($id, $invalidBehavior = ContainerInterface::INVALID_BEHAVIOR_EXCEPTION)
    {
        return $this->doGet($id, $invalidBehavior);
    }

    /**
     * @param     $id
     * @param int $invalidBehavior
     *
     * @return mixed|null|string
     * @throws \Exception
     */
    private function doGet($id, $invalidBehavior = ContainerInterface::INVALID_BEHAVIOR_EXCEPTION)
    {
        if (!parent::has($id)) {
            if (null !== ($definition = $this->getDefinition($id))) {
                if (null === ($service = $this->_createService($definition))) {
                    return null;
                }

                $this->set($id, $service);
            }
        }

        return parent::get($id, $invalidBehavior);
    }

    /**
     * @return static
     *
     * @throws \Exception
     */
    public function load()
    {
        if ($this->loaded)
            throw new \RuntimeException("Already loaded");

        foreach($this->extensions as $extension) {
            $extension->load($this);
        }

        $this->loaded = true;

        return $this;
    }

    /**
     * @param Definition $definition
     *
     * @return object
     */
    private function _createService(Definition $definition)
    {

        if ($definition->isDeprecated())
            @\trigger_error($definition->getDeprecationMessage(), E_USER_DEPRECATED);

        if (null !== ($factory = $definition->getFactory())) {
            if (\is_array($factory)
                && 2 == \count($factory)) {
                return \call_user_func($factory);
            } else if (\is_callable($factory)) {
                return $factory;
            }
        }

        try
        {

            /** @var array $args */
            $args = $this->doResolveServices($definition->getArguments());
            $service = (new \ReflectionClass($definition->getClass()))->newInstanceArgs($args);

            foreach($definition->getProperties() as $property => $value) {
                try
                {
                    $reflector = new \ReflectionProperty($definition->getClass(), $property);
                    $reflector->setValue($service, $value);
                } catch(\ReflectionException $e) {

                }
            }

            foreach($definition->getMethodCalls() as $method => $arguments) {
                try
                {
                    $reflector = new \ReflectionMethod($definition->getClass(), $method);
                    $arguments = $this->doResolveServices($arguments);
                    $reflector->invokeArgs($service, $arguments);
                } catch(\ReflectionException $e) {}
            }

            return $service;
        } catch(\Exception $e) {

        }

        return null;
    }

    /**
     * @param $value
     *
     * @return array|mixed|null|string
     * @throws \Exception
     */
    private function doResolveServices($value)
    {
        if (\is_array($value) && !empty($value)) {
            $i = 0;
            $count = \count($value);
            do
            {
                $value[ $i ] = $this->doResolveServices($value[$i]);
                $i++;
            } while($i < $count);

            return $value;
        } else if ($value instanceof Reference) {
            return $this->doGet($value->getName());
        } else {
            return $value;
        }
    }
}