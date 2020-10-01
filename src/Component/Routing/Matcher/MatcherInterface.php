<?php

namespace Xand\Component\Routing\Matcher;
use Xand\Component\Foundation\ServerRequest;

/**
 * Interface MatcherInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface MatcherInterface
{
	/**
	 * @param ServerRequest $request
	 */
	public function match(ServerRequest $request);
}