<?php

namespace Xand\Component\Database;

/**
 * Class ConnectionResolver
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ConnectionResolver
{
    /**
     * @var ConnectionInterface[]
     */
    protected $connections;
	
	/**
	 * @var string
	 */
	protected $default;
	
	/**
	 * @var ConnectionFactoryInterface
	 */
	protected $factory;

    /**
     * ConnectionResolver constructor.
     *
     * @param ConnectionFactoryInterface    $factory
     * @param string                        $default
     */
    public function __construct(ConnectionFactoryInterface $factory = null, $default = 'default')
    {
        $this->connections = [];
		$this->factory = null === $factory ? new ConnectionFactory() : $factory;
		$this->default = $default;
    }

    /**
     * @param array $config
     *
     * @return ConnectionInterface
     */
	public function newConnection(array $config)
	{
		return $this->factory->make($config);
	}
	
    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasConnection($name)
    {
        return isset($this->connections[$name]);
    }
	
    /**
     * @param string $name
     * @param ConnectionInterface $connection
     *
     * @return static
     */
    public function setConnection($name, ConnectionInterface $connection)
    {
        $this->connections[$name] = $connection;

        return $this;
    }
	
    /**
     * @param string|null   $name
     *
     * @return ConnectionInterface
     */
    public function getConnection($name = null)
    {
        $name = null === $name ? $this->default : $name;

        if (!$this->hasConnection($name))
            throw new \RuntimeException( sprintf("Unexpected connection name: %s", $name));
		
        return $this->connections[$name];
    }

    /**
     * @param string    $name
     *
     * @return static
     */
    public function removeConnection($name)
    {
        if ($this->hasConnection($name)) unset($this->connections[$name]);
		
        return $this;
    }
	
	/**
	 * @param string    $name
	 * 
	 * @return static
	 */
	public function setDefault($name)
	{
		$this->default = $name;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDefault()
	{
		return $this->default;
	}
}