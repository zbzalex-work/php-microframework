<?php

namespace Xand\Component\Log\Formatter;
use Xand\Component\Log\LogRecordInterface;

/**
 * Interface FormatterInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface FormatterInterface
{
    /**
     * @param LogRecordInterface    $record
     *
     * @return mixed
     */
	public function format(LogRecordInterface $record);
}