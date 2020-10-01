<?php

namespace Xand\Component\Security\User;

/**
 * Class User
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class User implements UserInterface
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var bool
     */
    protected $authenticated;

    /**
     * User constructor.
     *
     * @param null|string $username
     * @param null|string $password
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->authenticated = false;
    }

    /**
     * @return null|string
     */
	public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return null|string
     */
	public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool
     */
	public function isAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * @param bool $authenticated
     *
     * @return $this|mixed
     */
	public function setAuthenticated($authenticated = true)
    {
        $this->authenticated = $authenticated;

        return $this;
    }
}