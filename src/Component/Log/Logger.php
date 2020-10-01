<?php

namespace Xand\Component\Log;
use Xand\Component\Log\Handler\HandlerInterface;

/**
 * Class Logger
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Logger implements LoggerInterface
{
    /**
     * @var HandlerInterface[]
     */
    protected $handlers;

    /**
     * @param HandlerInterface[]    $handlers
     */
    public function __construct(array $handlers = [])
    {
        foreach($handlers as $handler) $this->addHandler($handler);
    }

    /**
     * @param HandlerInterface  $handler
     * 
     * @return static
     */
    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $params = [])
    {
		if ( ! in_array($level, $this->getLevels()))
			throw new \InvalidArgumentException();
		
        if ($this->handlers)
        {
            $record = new LogRecord($level, $message, $params);
            foreach($this->handlers as $handler)
                $handler($record);
        }

        return $this;
    }
	
	/**
	 * @return int[]
	 */
	public function getLevels()
	{
		return [
			LogLevel::DEBUG,
			LogLevel::INFO,
			LogLevel::WARNING,
			LogLevel::ERROR,
            LogLevel::FATAL
		];
	}
}
