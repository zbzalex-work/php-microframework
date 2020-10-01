<?php

namespace Xand\Component\Foundation;

/**
 * Class RequestMatcher
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class RequestMatcher
{
	/**
	 * @var string
	 */
	protected $pattern;
	
	/** 
	 * @param string	$pattern
	 */
	public function __construct($pattern)
	{
		$this->pattern = $pattern;
	}
	
	/**
	 * @param ServerRequest	$request
	 * 
	 * @return bool
	 */
	public function match(ServerRequest $request)
	{
		return null !== $request->getUri() && preg_match($this->pattern, $request->getUri()->getPath());
	}
}