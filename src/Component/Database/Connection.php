<?php

namespace Xand\Component\Database;
use Xand\Component\Log\LoggerInterface;

/**
 * Class Connection
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Connection implements ConnectionInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;
	
	/**
	 * @var LoggerInterface
	 */
	protected $logger;

    /**
     * @var array
     */
	protected $queryStack;

    /**
     * Connection constructor.
     *
     * @param \PDO|null                                                     $pdo
     * @param \Xand\Component\Log\LoggerInterface|null                      $logger
     */
    public function __construct(\PDO $pdo = null, LoggerInterface $logger = null)
    {
		$this->pdo = $pdo;
		$this->logger = $logger;
		$this->queryStack = [];
    }
	
	/**
	 * @param \PDO $pdo
	 * 
	 * @return static
	 */
	public function setPdo(\PDO $pdo)
	{
		$this->pdo = $pdo;
		
		return $this;
	}
	
    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }
	
	/**
	 * @param LoggerInterface $logger
	 * 
	 * @return static
	 */
	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
		
		return $this;
	}
	
	/**
	 * @return LoggerInterface
	 */
	public function getLogger()
	{
		return $this->logger;
	}

    /**
     * @param string $queryString
     * @param array $params
     * 
     * @return mixed
     */
    public function executeNativeQuery($queryString, array $params = [])
    {
        $query = [
            $queryString,
            $params
        ];

        $st = $this->pdo->prepare($queryString);

        try
        {
            $st->execute($params);
        } catch (\Exception $e) {
            $query[] = $st->errorInfo();
        }

        $this->queryStack[] = $query;

        return $st;
    }

    /**
     * @param string	$query
     * @param array		$params
	 * 
     * @return mixed
     */
    public function executeNativeQueryInsideTransaction($query, array $params = [])
    {
        try
		{
            $this->pdo->beginTransaction();
            $st = $this->executeNativeQuery($query, $params);
            $this->pdo->commit();

            return $st;
        } catch(\PDOException $e) {
            $this->pdo->rollback();
        }
    }

    /**
     * @return array
     */
    public function getQueryStack()
    {
        return $this->queryStack;
    }

    /**
     * @param string $pattern
     *
     * @return array
     */
    public function grep($pattern)
    {
        $result = [];

        foreach($this->queryStack as $query) {
            if (\preg_match("/" . $pattern . "/iu", $query[0])) {
                $result[] = $query;
            }
        }

        return $result;
    }

    /**
     * @throws \BadMethodCallException
     */
    public function __sleep()
    {
        throw new \BadMethodCallException("You cannot serialize or unserialize Connection instance");
    }

    /**
     * @throws \BadMethodCallException
     */
    public function __wakeup()
    {
        throw new \BadMethodCallException();
    }
}