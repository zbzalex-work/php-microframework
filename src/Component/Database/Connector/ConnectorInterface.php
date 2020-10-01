<?php

namespace Xand\Component\Database\Connector;

/**
 * Interface ConnectorInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ConnectorInterface
{
	/**
	 * @param array $config
	 * 
	 * @return ConnectorInterface
	 */
	public function connect(array $config);
}