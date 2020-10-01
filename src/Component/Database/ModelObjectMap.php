<?php

namespace Xand\Component\Database;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;

/**
 * Class ModelObjectMap
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ModelObjectMap
{
    /**
     * @var ModelResolver
     */
    protected $resolver;

    /**
     * ModelObjectMap constructor.
     */
    public function __construct()
    {
        $this->resolver = new ModelResolver();
    }

    /**
     * @param ModelResolver $resolver
     *
     * @return static
     */
    public function setResolver(ModelResolver $resolver)
    {
        $this->resolver = $resolver;

        return $this;
    }

    /**
     * @param string    $class
     *
     * @return object
     *
     * @throws \Exception
     */
    public function getModel($class)
    {
        if (!class_exists($class))
            throw new \Exception();

        return $this->resolver->resolve($class);
    }
}