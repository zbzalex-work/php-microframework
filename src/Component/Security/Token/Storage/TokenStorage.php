<?php

namespace Xand\Component\Security\Token\Storage;
use Xand\Component\Security\Token\TokenInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class TokenStorage implements TokenStorageInterface
{
	/**
	 * @var TokenInterface
	 */
	protected $token;
	
	/**
	 * @param TokenInterface $token
	 * 
	 * @return static
	 */
	public function setToken(
		TokenInterface $token
	)
	{
		$this->token = $token;
		
		return $this;
	}
	
	/**
	 * @return TokenInterface
	 */
	public function getToken()
	{
		return $this->token;
	}
}