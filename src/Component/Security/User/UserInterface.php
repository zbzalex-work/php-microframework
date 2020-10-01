<?php

namespace Xand\Component\Security\User;

/**
 * Interface UserInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface UserInterface
{
	/**
	 * @return string
	 */
	public function getUsername();
	
	/**
	 * @return string
	 */
	public function getPassword();
	
	/**
	 * @return bool
	 */
	public function isAuthenticated();

    /**
     * @param bool $authenticated
     *
     * @return mixed
     */
	public function setAuthenticated($authenticated = true);
}