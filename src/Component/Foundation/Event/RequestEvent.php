<?php

namespace Xand\Component\Foundation\Event;
use Xand\Component\EventDispatcher\Event;
use Xand\Component\Foundation\ServerRequest;
use Xand\Component\Foundation\Response;

/**
 * Class RequestEvent
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class RequestEvent extends Event
{
    /**
     * @var ServerRequest
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param ServerRequest	$request
     */
    public function __construct(ServerRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return ServerRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param ServerRequest	$request
     * 
     * @return static
     */
    public function setRequest(ServerRequest $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response	$response
     * 
     * @return static
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasResponse()
    {
        return null !== $this->response;
    }
}