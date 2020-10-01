<?php

namespace Xand\Component\Foundation\Event;

use Xand\Component\Foundation\Response;
use Xand\Component\Foundation\ServerRequest;

/**
 * Class ResponseEvent
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class TerminateEvent
{
    
    protected $req;
    protected $res;

    public function __construct(ServerRequest $req, Response $res)
    {
        $this->req = $req;
        $this->res = $res;
    }

    public function getRequest()
    {
        return $this->req;
    }

    public function setRequest(ServerRequest $req)
    {
        $this->req = $req;
        return $this;
    }

    public function getResponse()
    {
        return $this->res;
    }

    public function setResponse(Response $res)
    {
        $this->res = $res;
        return $this;
    }
}