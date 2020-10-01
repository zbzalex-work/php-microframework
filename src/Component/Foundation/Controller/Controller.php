<?php

namespace Xand\Component\Foundation\Controller;
use Xand\Component\Foundation\Response;
use Xand\Component\Foundation\Result;

/**
 * Class Controller
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Controller
{
    /**
     * @param \Xand\Component\Foundation\Response $response
     *
     * @throws \Xand\Component\Foundation\Result
     */
	public function send(Response $response)
	{
		throw new Result($response);
	}
}