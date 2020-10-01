<?php

namespace Xand\Component\Security\Authentication;
use Xand\Component\Security\Token\TokenInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class AuthenticationManager implements AuthenticationManagerInterface
{
	/**
	 * @var AuthenticationProviderInterface[]
	 */
	protected $providers;
	
	public function __construct()
	{
		$this->providers = [];
	}
	
	/**
	 * @param AuthenticationProviderInterface $provider
	 * 
	 * @return static
	 */
	public function register(AuthenticationProviderInterface $provider)
	{
		$this->providers[] = $provider;
		
		return $this;
	}
	
	/**
	 * @param TokenInterface $token
	 * 
	 * @return static
	 */
	public function authenticate(TokenInterface $token)
	{

		foreach($this->providers as $provider) {
			if (!$provider->supports($token)) continue;
			
			$provider->authenticate($token);
		}
		
		return $this;
	}
}