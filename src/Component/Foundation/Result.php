<?php

namespace Xand\Component\Foundation;

/**
 * Class Result
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Result extends \Exception
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Response	$response
     */
    public function __construct(Response $response)
	{
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}