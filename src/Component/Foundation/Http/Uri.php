<?php

namespace Xand\Component\Foundation\Http;

/**
 * Class Uri
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Uri
{
    protected $scheme, $username, $password, $host, $port, $path, $queryString, $fragment;

    /**
     * @param string	$url
     */
    public function __construct($url)
    {
        if (false === ($components = @parse_url($url)))
            throw new \InvalidArgumentException( 'Failed to parse url: ' . $url );

		if (isset($components['scheme']))
			$this->scheme = $components['scheme'];
		if (isset($components['host']))
			$this->host = $components['host'];
		if (isset($components['port']))
			$this->port = $components['port'];
		if (isset($components['user']))
			$this->username = $components['user'];
		if (isset($components['pass']))
			$this->password = $components['pass'];
		if (isset($components['path']))
			$this->path = $components['path'];
		if (isset($components['query']))
			$this->queryString = $components['query'];
		if (isset($components['fragment']))
			$this->fragment = $components['fragment'];
    }
	
    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string	$scheme
     * 
     * @return static
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;

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

    /**
     * @param string	$username
     * @param string	$password
     * 
     * @return static
     */
    public function setUserInfo($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }
	
	/**
	 * @return string
	 */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * 
     * @return static
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }
	
	/**
	 * @return int
	 */
	public function getPort()
	{
		return $this->port;
	}
	
	/**
	 * @param int	$port
	 * 
	 * @return static
	 */
	public function setPort($port)
	{
		$this->port = $port;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPath()
	{
		return \htmlentities(\urldecode($this->path), ENT_QUOTES);
	}
	
	/**
	 * @param string	$path
	 * 
	 * @return static
	 */
	public function setPath($path)
	{
		$this->path = $path;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getQueryString()
	{
		return \htmlentities(\urldecode($this->queryString), ENT_QUOTES);
	}
	
	/**
	 * @param string	$queryString
	 * 
	 * @return static
	 */
	public function setQueryString($queryString)
	{
	    $this->queryString = $queryString;

		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getFragment()
	{
		return \htmlentities(\urldecode($this->fragment), ENT_QUOTES);
	}
	
	/**
	 * @param string	$fragment
	 * 
	 * @return static
	 */
	public function setFragment($fragment)
	{
		$this->fragment = $fragment;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getUri()
	{
		$uri = null !== $this->scheme
			? $this->scheme . '://'
			: null;
		$uri.= null !== $this->username
			|| null !== $this->password
			? $this->username . ':' . $this->password . '@'
			: null;
		$uri.= null !== $this->host
			? $this->host
			: null;
		$uri.= null !== $this->path
			? $this->path
			: '/';
		$uri.= null !== $this->queryString
			? '?' . $this->queryString
			: null;
		$uri.= null !== $this->fragment
			? '#' . $this->fragment
			: null;
		
		return $uri;
	}

    /**
     * @return string
     */
	public function __toString()
    {
        return $this->getUri();
    }
}