<?php

namespace Xand\Component\Database;

/**
 * Interface ConnectionFactoryInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ConnectionFactoryInterface
{
	/**
	 * @param array $config
	 * 
	 * @return ConnectionInterface
	 */
	public function make(array $config);
}