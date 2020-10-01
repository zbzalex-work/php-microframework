<?php

namespace Xand\Component\Templating\Storage;

/**
 * Class StringStorage
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class StringStorage implements StorageInterface
{
	/**
	 * @var string
	 */
	protected $content;
	
	/**
	 * @param string $content
	 */
	public function __construct($content)
	{
		$this->content = $content;
	}
	
	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
}