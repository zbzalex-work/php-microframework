<?php

namespace Xand\Component\Foundation\Bundle;
use Xand\Component\DependencyInjection\ContainerAware;

/**
 * Class Bundle
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class Bundle extends ContainerAware implements BundleInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var string
     */
    protected $path;

    /**
     * @return mixed|void
     */
    public function boot()
	{
		
	}

    /**
     * @return mixed|void
     */
	public function shutdown()
    {

    }

    /**
     * @return string
     */
	public function getExtensionClass()
    {
        return "\\" . $this->getName() . "Bundle\\DependencyInjection\\" . $this->getName() . "Extension";
    }

    /**
     * @return null|object
     */
    protected function createExtension()
    {
        $class = $this->getExtensionClass();

        return \class_exists($class) ? new $class() : null;
    }

    /**
     * @return null|object
     */
    public function getExtension()
    {
        if (null === $this->extension)
                     $this->extension = $this->createExtension();

        return $this->extension;
    }

    /**
     * @return bool|string
     */
	public function getName()
    {
        if (null === $this->name) {
            $this->name = substr($this->_parseClass()[1], 0, -6);
        }

        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        if (null === $this->namespace) {
            $this->namespace = $this->_parseClass()[0];
        }

        return $this->namespace;
    }

    /**
     * @return string[]
     */
    private function _parseClass()
    {
        $class = \ltrim(\get_class($this), "\\");
        $className = $class;
        $namespace = null;
        if (false !== ($pos = \strrpos($class, "\\"))) {
            $namespace = \substr($class, 0, $pos);
            $className = \substr($class, $pos +1);
        }

        return [
            $namespace,
            $className
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        if (null === $this->path)
        {
            $reflector = new \ReflectionObject($this);
            $this->path = \dirname($reflector->getFileName());
        }

        return $this->path;
    }
}