<?php

namespace Xand\Component\Filesystem;

/**
 * Class InputStreamReader
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class InputStreamReader
{
	/**
	 * @var StreamInterface
	 */
	protected $stream;

    /**
     * InputStreamReader constructor.
     */
	public function __construct()
	{
		$this->stream = new Stream(@\fopen('php://stdin', 'r'));
	}
	
	/**
	 * @return StreamInterface
	 */
	public function getStream()
	{
		return $this->stream;
	}

    /**
     * @param \Closure $callable
     *
     * @return $this
     * @throws \Exception
     */
	public function readLine(\Closure $callable)
	{
		$line = null;
		
		do
		{
			$string = $this->stream->read();
			$line.= $string;
			
			if (false !== \strpos($string, "\n")
			 || false !== \strpos($string, "\t")
			 || false !== \strpos($string, "\r"))
			{
				
				//$this->stream->rewind();
				
				$callable($line);
				
				break;
			}
		} while(1);
		
		return $this;
	}
}