<?php

namespace Xand\Component\Foundation;

/**
 * Class JsonResponse
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class JsonResponse extends Response
{
    /**
     * JsonResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct(\json_encode($data), [
            "Content-Type" => "application/json; charset=utf8"
        ]);
    }
}