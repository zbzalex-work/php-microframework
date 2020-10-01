<?php

namespace Xand\Component\Database\Query;

/**
 * Class Criteria
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Condition
{
	/**
	 * @var string[]
	 */
	protected $sqlStack;

	/**
	 * @var Order[]
	 */
	protected $order;
	
	/**
	 * @var string[]
	 */
	protected $args;
	
	/**
	 * @var Limit
	 */
	protected $limit;

    /**
     * @var int
     */
	protected $offset;

    /**
     * Criteria constructor.
     */
	public function __construct()
	{
		$this->sqlStack = [];
		$this->order = [];
		$this->limit = null;
		$this->args = [];
	}


    /**
     * @param null  $sql
     * @param array $args
     *
     * @return $this|null|string
     */
	public function sql($sql = null, array $args = [])
	{
		if (null === $sql) {

			if ($this->order) {
				$this->sqlStack[] = "ORDER BY " . implode(", ", \array_map(function($order) {
				    /** @var \Xand\Component\Database\Query\Order $order */
						return $order->toSql(false);
						}, $this->order));
			}

			if (null !== $this->limit) {
				$this->sqlStack[] = $this->limit->toSql();
			}

			if (null !== $this->offset) {
			    $this->sqlStack[] = "OFFSET " . $this->offset;
            }
			
			return \implode(" ", $this->sqlStack);
		}

		if (!$this->sqlStack)
		     $this->sqlStack[] = "WHERE";

		$this->sqlStack[] = $sql;
		foreach($args as $val) {
		    $this->args[] = $val;
		}

		return $this;
	}

    /**
     * @return string[]
     */
    public function getArgs()
    {
        return $this->args;
    }


    public static function quoteParam($id)
    {
        if ("`" != $id[0]) {
            if (false !== ($pos = \strpos($id, "."))) {
                $placeholder = \substr($id, 0, $pos);
                $id = \substr($id, $pos + 1);
                return "`$placeholder`.`$id`";
            }
            else {
                return "`$id`";
            }
        }

        return $id;
    }

    /**
     * @param string $key
     * @param string $val
     * @param string $op
     *
     * @return static
     */
    public function _op($key, $val, $op)
    {
        $this->sqlStack[] = (!$this->sqlStack ? "WHERE" : "AND")
            . " " . sprintf('%s %s ?', static::quoteParam($key), $op);
        $this->args[] = $val;

        return $this;
    }

    /**
     * @param string $col
     * @param string $val
     *
     * @return static
     */
    public function eq($col, $val)
    {
        $this->_op($col, $val, '=');

        return $this;
    }

    /**
     * @param string    $col
     * @param string    $val
     *
     * @return static
     */
    public function ne($col, $val)
    {
        $this->_op($col, $val, '!=');

        return $this;
    }

    public function gt($col, $val)
    {
        $this->_op($col, $val, ">");

        return $this;
    }

    public function ge($col, $val)
    {
        $this->_op($col, $val, ">=");

        return $this;
    }

    public function lt($col, $val)
    {
        $this->_op($col, $val, "<");

        return $this;
    }

    public function le($col, $val)
    {
        $this->_op($col, $val, "<=");

        return $this;
    }

    public function in($col, $values)
    {
        $this->sql($col . " IN (" . implode(", ", $values) . ")");

        return $this;
    }

    /**
     * @param string    $col
     * @param string    $val
     *
     * @return static
     */
    public function isNull($col, $val)
    {
        $this->_op($col, $val, "IS NULL");

        return $this;
    }

    /**
     * @param string    $col
     * @param string    $val
     *
     * @return static
     */
    public function notNull($col, $val)
    {
        $this->_op($col, $val, "NOT NULL");

        return $this;
    }

    /**
     * @param string    $col
     * @param string    $val
     *
     * @return static
     */
    public function like($col, $val)
    {
        $this->_op($col, $val, "LIKE");

        return $this;
    }

    /**
     * @param Condition[] $map
     *
     * @return static
     */
    public function addOr(array $map)
    {
        $i = 0;

        foreach($map as $expr) {
            if (0 != $i)
                $this->sqlStack[] = " OR ";

            $this->sqlStack[] = '(' . $expr->getSql() . ')';

            foreach($expr->getArgs() as $value) {
                $this->args[] = $value;
            }

            $i++;
        }

        return $this;
    }

	/**
	 * @param Order $order
	 * 
	 * @return static
	 */
	public function addOrder(Order $order)
	{
		$this->order[] = $order;
		
		return $this;
	}
	
	/**
	 * @param Limit	$limit
	 * 
	 * @return static
	 */
	public function setLimit(Limit $limit)
	{
		$this->limit = $limit;
		
		return $this;
	}

	public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function append(Condition $criteria)
    {
        $this->sql((string)$criteria);

        foreach($criteria->getArgs() as $value) {
            $this->args[] = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
	public function __toString()
    {
        return $this->sql();
    }
}