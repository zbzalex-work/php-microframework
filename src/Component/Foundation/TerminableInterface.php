<?php

namespace Xand\Component\Foundation;

/**
 * Interface TerminableInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface TerminableInterface
{
    /**
     * @param \Xand\Component\Foundation\ServerRequest $request
     * @param \Xand\Component\Foundation\Response      $response
     *
     * @return mixed
     */
    public function terminate(ServerRequest $request, Response $response);
}