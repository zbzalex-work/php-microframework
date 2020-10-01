<?php

namespace Xand\Component\DependencyInjection;

/**
 * Class Container
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $data;
	
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param string $id
     * 
     * @return bool
     */
    public function has($id)
    {
        return isset($this->data[$id]);
    }

    /**
     * @param string $id
     * @param string $value
     * 
     * @return static
     */
    public function set($id, $value)
    {
		$this->data[$id] = $value;
		
		return $this;
    }

    /**
     * @param string $id
     * @param int    $invalidBehavior
     *
     * @return mixed|null|string
     * @throws \Exception
     */
    public function get($id, $invalidBehavior = ContainerInterface::INVALID_BEHAVIOR_NONE)
    {
        if (!$this->has($id)) {
            switch($invalidBehavior) {
                case ContainerInterface::INVALID_BEHAVIOR_EXCEPTION:
                    {
                        throw new \Exception(sprintf("Undefined service: %s", $id));
                    }
                    break;
                default:
                case ContainerInterface::INVALID_BEHAVIOR_RETURN_NULL:
                    {
                        return null;
                    }
                    break;
            }
        }

        $value = $this->data[$id];

        return (\is_object($value) && (\method_exists($value, "__invoke")
                || $value instanceof \Closure)) || \is_callable($value) ? $value($this) : $value;

    }

    /**
     * @param string $id
     *
     * @return static
     */
    public function remove($id)
    {
        if ($this->has($id)) {
            unset($this->data[$id]);
        }
		
        return $this;
    }

    /**
     * @param \Closure $callable
     *
     * @return \Closure|mixed
     */
    public function singleton(\Closure $callable)
    {
		$context = $this;
		
		return function() use($callable, $context) {

			static $value;

			if (null === $value) {
			    $value = $callable($context);
            }
			
			return $value;
		};
    }
	
	/**
	 * @param string $offset
	 * 
	 * @throws \BadMethodCallException
	 * 
	 * @return void
	 */
    public function offsetExists($offset)
    {
        throw new \BadMethodCallException();
    }
	
	/**
	 * @param string $key
	 * @param string $value
	 * 
	 * @return void
	 */
    public function offsetSet($key, $value)
    {
		$this->set($key, $value);
    }

    /**
     * @param string $key
     *
     * @return mixed|null|string
     * @throws \Exception
     */
    public function offsetGet($key)
    {
		return $this->get($key);
    }
	
	/**
	 * @param string $key
	 * 
	 * @throws \BadMethodCallException
	 * 
	 * @return void
	 */
    public function offsetUnset($key)
    {
        throw new \BadMethodCallException();
    }
}