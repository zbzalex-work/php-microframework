<?php

namespace Xand\Component\Security\Authentication;
use Xand\Component\Security\Token\TokenInterface;
use Xand\Component\Security\User\UserProviderInterface;

/**
 * Class AuthenticationProvider
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class AuthenticationProvider implements AuthenticationProviderInterface
{
	/**
	 * @var UserProviderInterface
	 */
	protected $provider;
	
	/**
	 * @param UserProviderInterface $provider
	 */
	public function __construct(UserProviderInterface $provider)
	{
		$this->provider = $provider;
	}
	
	/**
	 * @param TokenInterface $token
     */
	public function authenticate(TokenInterface $token) {}
	
	/**
	 * @param TokenInterface $token
	 * 
	 * @return bool
	 */
	public function supports(TokenInterface $token)
	{
		return $token instanceof TokenInterface;
	}
}