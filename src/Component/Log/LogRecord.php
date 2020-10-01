<?php

namespace Xand\Component\Log;

/**
 * Class LogRecord
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class LogRecord implements LogRecordInterface
{
    /**
     * @var int
     */
    protected $level;
	
    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $params;

    /**
     * @param int       $level
     * @param string    $message
     * @param array     $params
     */
    public function __construct($level, $message, array $params = [])
    {
        $this->level = $level;
        $this->message = $message;
        $this->params = $params;
    }

    /**
     * @param int   $level
     * 
     * @return static
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string    $message
     * 
     * @return static
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
	
    /**
     * @param array $params
     * 
     * @return static
     */
    public function setParams(array $params)
    {
        foreach($params as $key => $value)
            $this->params[ $key ]= $value;

        return $this;
    }
	
	/**
	 * @param string    $param
	 * 
	 * @return bool
	 */
	public function hasParam($param)
	{
		return array_key_exists($param, $this->params);
	}
	
	/**
	 * @param string    $param
	 * 
	 * @return mixed
	 */
	public function getParam($param)
	{
	    return $this->hasParam($param) ? $this->params[ $param ] : null;
	}
	
	/**
	 * @param string    $param
	 * 
	 * @return static
	 */
	public function removeParam($param)
	{
		if (isset($this->params[ $param ]))
            unset($this->params[ $param ]);

		return $this;
	}

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}