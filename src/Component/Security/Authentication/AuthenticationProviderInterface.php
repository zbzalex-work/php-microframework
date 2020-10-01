<?php

namespace Xand\Component\Security\Authentication;
use Xand\Component\Security\Token\TokenInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface AuthenticationProviderInterface
{
	/**
	 * @param TokenInterface $token
	 */
	public function authenticate(
		TokenInterface $token
	);
}