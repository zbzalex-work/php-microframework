<?php

namespace Xand\Component\Foundation;

/**
 * Interface KernelInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface KernelInterface
{
    /**
     * @param \Xand\Component\Foundation\ServerRequest $request
     *
     * @return mixed
     */
    public function handleRequest(ServerRequest $request = null);
}