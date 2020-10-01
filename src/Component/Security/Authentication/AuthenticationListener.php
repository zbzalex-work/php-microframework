<?php

namespace Xand\Component\Security\Authentication;
use Xand\Component\EventDispatcher\EventListenerInterface;
use Xand\Component\Security\Token\Storage\TokenStorageInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class AuthenticationListener implements EventListenerInterface
{
	/**
	 * @var TokenStorage
	 */
	protected $storage;
	
	/**
	 * @var AuthenticationManagerInterface
	 */
	protected $manager;
	
	/**
	 * @param TokenStorageInterface $storage
	 * @param AuthenticationManagerInterface $manager
	 */
	public function __construct(TokenStorageInterface $storage, AuthenticationManagerInterface $manager)
	{
		$this->storage = $storage;
		$this->manager = $manager;
	}
}