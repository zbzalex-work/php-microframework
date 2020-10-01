<?php

namespace Xand\Component\Log\Handler;
use Xand\Component\Log\Formatter\FormatterInterface;
use Xand\Component\Log\Formatter\Formatter;
use Xand\Component\Log\LogRecordInterface;
use Xand\Component\Filesystem\File;
use Xand\Component\Filesystem\Stream;

/**
 * Class FileHandler
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FileHandler implements HandlerInterface
{
	/**
	 * @var File
	 */
	protected $file;
	
	/**
	 * @var FormatterInterface
	 */
	protected $formatter;
	
	/**
	 * @var callable[]
	 */
	protected $filters = [];
	
	/**
	 * @param File                  $file
	 * @param FormatterInterface 	$formatter
	 */
	public function __construct(File $file, FormatterInterface $formatter = null)
	{
		$this->file = $file;
		$this->formatter = null === $formatter ? new Formatter() : $formatter;
	}
	
	/**
	 * @param FormatterInterface    $formatter
     * 
     * @return static
	 */
	public function setFormatter(FormatterInterface $formatter)
	{
		$this->formatter = $formatter;
		
		return $this;
	}
	
	/**
	 * @return FormatterInterface
	 */
	public function getFormatter()
	{
		return $this->formatter;
	}
	
	/**
	 * @param callable	$callable
     *
     * @return static
	 */
	public function addFilter($callable)
	{
		$this->filters[] = $callable;
		
		return $this;
	}
	
	/**
	 * @param LogRecordInterface	$record
	 * 
	 * @return bool
	 */
	public function isLoggable(LogRecordInterface $record)
	{
		foreach($this->filters as $filter) {
			if (call_user_func($filter, $record)) {
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * @param LogRecordInterface	$record
	 * 
	 * @return string
	 */
	public function flush(LogRecordInterface $record)
	{
		return $this->formatter->format($record);
	}
	
	/**
	 * @param LogRecordInterface	$record
	 * 
	 * @return static
	 */
	public function __invoke(LogRecordInterface $record)
	{
		if ($this->isLoggable($record)) {
		    /** @var string */
			$formatted = $this->formatter->format($record);

			try
			{
			    if (!$this->file->hasParent())
			         $this->file->setParent(new File($this->file->getPath()));

			    if (!$this->file->getParent()->isDir())
                     $this->file->getParent()->mkdirs();

			    $this->file->getStream()->write($formatted . "\n")->close();
			} catch(\Exception $e) {

			}
		}
		
		return $this;
	}
}