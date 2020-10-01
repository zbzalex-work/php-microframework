<?php

namespace Xand\Component\Security\Token;
use Xand\Component\Security\User\UserInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Token implements TokenInterface
{
	/**
	 * @var UserInterface
	 */
	protected $user;
	
	/**
	 * @return UserInterface
	 */
	public function getUser()
	{
		return $this->user;
	}
	
	/**
	 * @param UserInterface $user
	 * 
	 * @return static
	 */
	public function setUser(
		UserInterface $user
	)
	{
		$this->user = $user;
		
		return $this;
	}
}