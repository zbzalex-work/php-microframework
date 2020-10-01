<?php

namespace Xand\Component\Database\Exception;

/**
 * Class ActiveRecordException
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ActiveRecordException extends \Exception
{
    /**
     * @const int
     */
    const ATTR_NOT_FOUND = 0;

    /**
     * @const int
     */
    const OBJ_FROZEN = 1;

    /**
     * @const int
     */
    const METHOD_OR_ASSOC_NOT_FOUND = 2;

    /**
     * @const int
     */
    const RECORD_NOT_FOUND = 3;
}