<?php

namespace Xand\Component\Database\Connector;

/**
 * Class Connector
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class Connector implements ConnectorInterface
{
	/**
	 * @var array
	 */
	protected $options = [
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
	];
	
	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function hasOption($key)
	{
		return isset($this->options[$key]);
	}
	
	/**
	 * @param int $key
	 * @param int $value
	 * 
	 * @return static
	 */
	public function setOption($key, $value)
	{
		$this->options[$key] = $value;
		
		return $this;
	}
	
	/**
	 * @param array $options
	 * 
	 * @return static
	 */
	public function setOptions(array $options)
	{
		$this->options = $options;
		
		return $this;
	}
	
	/**
	 * @param int $option
	 * 
	 * @return static
	 */
	public function removeOption($option)
	{
		if (isset($this->options[ $option ]))
			unset($this->options[ $option ]);
		
		return $this;
	}
	
	/**
	 * @param array $options
	 * 
	 * @return static
	 */
	public function addOptions(array $options)
	{
		foreach ($options as $option => $value) {
		    $this->setOption($option, $value);
        }
		
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array $options
	 * 
	 * @return mixed
	 */
	public function createPdo($dsn, $username, $password, array $options = [])
	{
		try
		{
			return new \PDO($dsn, $username, $password, $options);
		} catch(\Exception $e) {
			
		}
	}
}