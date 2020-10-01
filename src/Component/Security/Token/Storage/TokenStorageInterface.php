<?php

namespace Xand\Component\Security\Token\Storage;
use Xand\Component\Security\Token\TokenInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface TokenStorageInterface
{
	/**
	 * @param TokenInterface $token
	 * 
	 * @return mixed
	 */
	public function setToken(TokenInterface $token);
	
	/**
	 * @param TokenInterface
	 */
	public function getToken();
}