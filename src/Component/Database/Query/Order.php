<?php

namespace Xand\Component\Database\Query;

/**
 * Class Order
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Order
{
	/**
	 * @var string
	 */
	protected $field;
	
	/**
	 * @var string
	 */
	protected $type;
	
	/**
	 * @const string
	 */
	const TYPE_ASC  = "ASC";
	
	/**
	 * @const string
	 */
	const TYPE_DESC = "DESC";

    /**
     * Order constructor.
     *
     * @param string $field
     * @param string $type
     */
	public function __construct($field, $type)
	{
		$this->field = $field;
		if (false === array_search($type, $this->getTypes()))
			throw new \InvalidArgumentException();
		
		$this->type = $type;
	}
	
	/**
	 * @return string
	 */
	public function getField()
	{
		return $this->field;
	}
	
	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * @return string[]
	 */
	public function getTypes()
	{
		return [
			static::TYPE_ASC,
			static::TYPE_DESC
		];
	}
	
	/**
	 * @return static
	 */
	public function asc()
	{
		$this->type =  "ASC";
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function desc()
	{
		$this->type = "DESC";
		
		return $this;
	}

    /**
     * @param bool $full
     *
     * @return string
     */
	public function toSql($full = true)
	{
		return ($full ? "ORDER BY " : "") . $this->field . " " . $this->type;
	}
}