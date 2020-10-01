<?php

namespace Xand\Component\Routing;

/**
 * Class Route
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Route implements RouteInterface
{
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	  @var string[]
	 */
	protected $schemes;
	
	/**
	 * @var string[]
	 */
	protected $methods;
	
	/**
	 * @var string
	 */
	protected $path;
	
	/**
	 * @var array
	 */
	protected $attributes;

    /**
     * Route constructor.
     *
     * @param        $name
     * @param string $methods
     * @param        $path
     * @param array  $attributes
     */
	public function __construct($name = null, $methods = '*', $path = null, array $attributes = [])
	{
		$this->name = $name;

		if (false !== \strpos($methods, "|"))
			$methods = \explode("|", $methods);
		
		$this->methods = (array)$methods;
		$this->path = $path;
		$this->attributes = $attributes;
		$this->schemes = [];
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/** 
	 * @param string $name
	 * 
	 * @return static
	 */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}

    /**
     * @return array|string[]
     */
	public function getSchemes()
	{
		return $this->schemes;
	}
	
	/**
	 * @param string	$scheme
	 * 
	 * @return static
	 */
	public function addScheme($scheme)
	{
		$this->schemes[] = $scheme;
		
		return $this;
	}

    /**
     * @param string[] $schemes
     *
     * @return static
     */
	public function setSchemes(array $schemes)
    {
        $this->schemes = $schemes;

        return $this;
    }

	/**
	 * @param string $scheme
	 * 
	 * @return bool
	 */
	public function hasScheme($scheme)
	{
		return false !== \array_search($scheme, $this->schemes);
	}
	
	/**
	 * @return string[]
	 */
	public function getMethods()
	{
		return $this->methods;
	}
	
	/**
	 * @param string[] $methods
	 * 
	 * @return static
	 */
	public function setMethods(array $methods)
	{
		$this->methods = $methods;
		
		return $this;
	}
	
	/**
	 * @param string $method
	 * 
	 * @return static
	 */
	public function addMethod($method)
	{
		$this->methods[] = $method;
		
		return $this;
	}
	
	/**
	 * @param string $method
	 * 
	 * @return bool
	 */
	public function hasMethod($method)
	{
		return false !== \array_search($method, $this->methods);
	}
	
	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
	
	/**
	 * @param string $path
	 * 
	 * @return static
	 */
	public function setPath($path)
	{
		$this->path = $path;
		
		return $this;
	}
	
	/**
	 * @param string $key
	 * 
	 * @return bool
	 */
	public function hasAttribute($key)
	{
		return isset($this->attributes[$key]);
	}
	
	/**
	 * @param string $key
	 * @param string $value
	 * 
	 * @return static
	 */
	public function setAttribute($key, $value)
	{
		$this->attributes[$key] = $value;
		
		return $this;
	}
	
	/**
	 * @param string $key
	 * 
	 * @return null|string
	 */
	public function getAttribute($key)
	{
		if ($this->hasAttribute($key))
			return $this->attributes[$key];
	}
	
	/**
	 * @param string $key
	 * 
	 * @return static
	 */
	public function removeAttribute($key)
	{
		if ($this->hasAttribute($key)) {
            unset($this->attributes[ $key ]);
        }
		
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

    /**
     * @param array $attributes
     */
	public function setAttributes(array $attributes)
	{
		$this->attributes = $attributes;
	}

    /**
     * @param array $attributes
     *
     * @return static
     */
	public function addAttributes(array $attributes)
    {
        foreach($attributes as $attribute => $value) {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }
}