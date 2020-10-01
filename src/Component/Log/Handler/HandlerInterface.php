<?php

namespace Xand\Component\Log\Handler;
use Xand\Component\Log\LogRecordInterface;

/**
 * Interface HandlerInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface HandlerInterface
{
	/**
	 * @param LogRecordInterface	$record
	 */
	public function __invoke(LogRecordInterface $record);
}