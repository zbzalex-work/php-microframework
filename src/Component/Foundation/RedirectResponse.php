<?php

namespace Xand\Component\Foundation;

/**
 * Class RedirectResponse
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class RedirectResponse extends Response
{
    /**
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct(null, [
            "Location" => $uri
        ]);
    }
}