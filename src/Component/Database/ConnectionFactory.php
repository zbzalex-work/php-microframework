<?php

namespace Xand\Component\Database;
use Xand\Component\Log\LoggerInterface;
use Xand\Component\Database\Connector\MysqlConnector;
use Xand\Component\Database\Connector\ConnectorInterface;

/**
 * Class ConnectionFactory
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ConnectionFactory implements ConnectionFactoryInterface
{
	/**
	 * @var LoggerInterface
	 */
	protected $logger;
	
	/**
	 * @param LoggerInterface   $logger
	 */
	public function __construct(LoggerInterface $logger = null)
	{
		$this->logger = $logger;
	}
	
	/**
	 * @return ConnectionInterface
	 */
	public function createConnection()
	{
		return new Connection();
	}
	
	/**
	 * @param string    $driver
	 * 
	 * @return ConnectorInterface
	 */
	public function createConnector($driver)
	{
		switch($driver) {
			case 'mysql' :
				{
					return new MysqlConnector();
				}
				break;
		}
	}
	
	/**
	 * @param array $config
	 * 
	 * @return ConnectionInterface
	 */
	public function make(array $config)
	{
		if (!isset($config['driver']))
			throw new \InvalidArgumentException( 'Not specified option "driver".' );

		/* @var \PDO */
		$pdo = $this->createConnector($config['driver'])->connect($config);
		$connection = $this->createConnection();
		
		$connection->setPdo($pdo);
		
		if (null !== $this->logger)
			$connection->setLogger($this->logger);
		
		return $connection;
	}
}