<?php

namespace Xand\Component\Database\Query;

/**
 * Class Limit
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Limit
{
	/**
	 * @var string
	 */
	protected $offset;
	
	/**
	 * @var string
	 */
	protected $max;
	
	/**
	 * @param null|int $offset
	 * @param null|int $max
	 */
	public function __construct($offset = null, $max = null)
	{
		$this->offset = $offset;
		$this->max = $max;
	}
	
	/**
	 * @return int
	 */
	public function getOffset()
	{
		return $this->offset;
	}
	
	/**
	 * @return int
	 */
	public function getMax()
	{
		return $this->max;
	}

    /**
     * @param bool $full
     *
     * @return string
     */
	public function toSql($full = true)
	{
		return ($full ? "LIMIT " : "")
            . (null === $this->offset ? "" : $this->offset)
            . (null !== $this->max
                ? (null !== $this->offset ? ", " : "") . $this->max
                : "");
	}

	public function __toString()
    {
        return $this->toSql();
    }
}