<?php

namespace Xand\Component\Foundation\Http;

/**
 * Class Cookie
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Cookie
{
    protected $name, $value, $expires, $path, $domain, $httpOnly, $secure;

    /**
     * @param string|null $name
     * @param string|null $value
     * @param int $expires
     * @param null|string $path
     * @param null|string $domain
     * @param bool $httpOnly
     * @param bool $secure
     */
    public function __construct($name = null, $value = null, $expires = 0, $path = null, $domain = null,
                                $httpOnly = false, $secure = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires;
        $this->path = $path;
        $this->domain = $domain;
        $this->httpOnly = $httpOnly;
        $this->secure = $secure;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param int $expires
     *
     * @return $this
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return static
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     *
     * @return static
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHttpOnly()
    {
        return $this->httpOnly;
    }

    /**
     * @param bool $flag
     *
     * @return static
     */
    public function setHttpOnly($flag = true)
    {
        $this->httpOnly = $flag;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @param bool $flag
     *
     * @return static
     */
    public function setSecure($flag = true)
    {
        $this->secure = $flag;

        return $this;
    }
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf("Set-Cookie:%s", $this->toValue());
	}

    /**
     * @return string
     */
    public function toValue()
    {
        $str = rawurlencode($this->name) . '=' . rawurlencode($this->value)
            . '; expires=' .gmdate('D, d-M-Y H:i:s', $this->expires) . ' GMT'
            . '; max-age=' . ($this->expires - time());

        if (null !== $this->path)
            $str.= '; path=' . $this->path;

        if (null !== ($domain = $this->domain)) {
            if ('www.' == substr($domain, 0, 4))
                $domain = substr($domain, 4);
            if ('.' != substr($domain, 0, 1))
                $domain.= '.' . $domain;
            if (false !== ($pos = strpos($domain, ':'))) {
                $domain.= substr($domain, 0, $pos);
            }

            $str .= '; domain=' . $domain;
        }
        if ($this->httpOnly)
            $str.= '; httponly';
        if ($this->secure)
            $str.= '; secure';
		
        return $str;
    }
}