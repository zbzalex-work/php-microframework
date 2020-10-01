<?php

namespace Xand\Component\Database\Connector;

/**
 * Class MysqlConnector
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class MysqlConnector extends Connector
{
	/**
	 * @param array $config
	 * 
	 * @return \PDO
	 */
	public function connect(array $config)
	{
		$dsn = $this->getDsn($config);
		$username = isset($config['username']) ? $config['username'] : 'root';
		$password = isset($config['password']) ? $config['password'] : '';
		
		if (isset($config['options']))
			$this->setOptions($config['options']);

		/* @var \PDO $pdo */
		$pdo = $this->createPdo($dsn, $username, $password, $this->getOptions());
		
		$st = $pdo->prepare('set names "' . (isset($config['charset'])
		? $config['charset']
		: 'utf8') . '" collate ' . (isset($config['collation'])
		? $config['collation']
		: 'utf8_general_ci') . ';');
		$st->execute();
		
		if (isset($config['strict'])) {
			$st = $pdo->prepare('set session sql_mode="STRICT_ALL_TABLES";');
			$st->execute();
		}
		
		return $pdo;
	}
	
	/**
	 * @param array $config
	 * 
	 * @return string
	 */
	public function getDsn(array $config)
	{
		return 'mysql:host=' . (isset($config['host']) ? $config['host'] : 'localhost')
		. ';port=' 	 . (isset($config['port']) ? $config['port'] : 3306)
		. ';dbname=' . (isset($config['name']) ? $config['name'] : null);
	}
}