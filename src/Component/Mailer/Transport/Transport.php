<?php

namespace Xand\Component\Mailer\Transport;

/**
 * Class Transport
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Transport
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var
     */
    protected $password;


    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return static
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return static
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return static
     */
    public function setUserInfo($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getUserInfo()
    {
        return [
            $this->username,
            $this->password
        ];
    }
}