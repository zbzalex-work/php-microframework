<?php

namespace Xand\Component\Security\Token;
use Xand\Component\Security\User\UserInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface TokenInterface
{
	/**
	 * @return UserInterface
	 */
	public function getUser();
	
	/**
	 * @param UserInterface $user
	 */
	public function setUser(UserInterface $user);
}