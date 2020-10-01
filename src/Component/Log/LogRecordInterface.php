<?php

namespace Xand\Component\Log;

/**
 * Interface LogRecordInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface LogRecordInterface
{
    /**
     *	@param int  $level
     */
    public function setLevel($level);

    /**
     *	@return int
     */
    public function getLevel();

    /**
     *	@param string   $message
     */
    public function setMessage($message);

    /**
     *	@return string
     */
    public function getMessage();

    /**
     *	@param array    $params
     */
    public function setParams(array $params);

    /**
     *	@return array
     */
    public function getParams();
}