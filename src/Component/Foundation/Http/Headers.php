<?php

namespace Xand\Component\Foundation\Http;

/**
 * Class Headers
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Headers
{
    /**
     * @var array
     */
    protected $headers;
	
    /**
     * @param array	$headers
     */
    public function __construct(array $headers = [])
    {
        $this->headers = [];
		
        foreach($headers as $header => $value)
			$this->set($header, $value);
    }
	
    /**
     * @param string	$header
     * 
     * @return mixed
     */
    public function get($header)
    {
		return $this->has($header) ? $this->headers[$header] : false;
    }
	
    /**
     * @param string	$header
	 * @param string	$separator
     * 
     * @return string|null
     */
    public function getLine($header, $separator = ',')
    {
        return ($_header = $this->get($header)) ? implode($separator, $_header) : null;
    }
	
    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
	
    /**
     * @param string $header
     * @param string $value
     * 
     * @return static
     */
    public function set($header, $value)
    {
        $this->headers[$header] = (array)$value;
		
        return $this;
    }
	
    /**
     * @param string	$header
     * @param string	$value
     * 
     * @return static
     */
    public function add($header, $value = null)
    {
        if (!$this->has($header))
			 $this->headers[$header] = [];
		
        $this->headers[$header][] = $value;
		
        return $this;
    }
	
    /**
     * @param string	$header
     * 
     * @return bool
     */
    public function has($header)
    {
        return isset($this->headers[$header]);
    }
	
    /**
     * @param string $header
     * 
     * @return static
     */
    public function remove($header)
    {
        if ($this->has($header))
			unset($this->headers[$header]);
		
        return $this;
    }
	
    /**
     * @param Cookie $cookie
     * 
     * @return static
     */
    public function addCookie(Cookie $cookie)
    {
        $this->add("Set-Cookie", $cookie->toValue());
		
        return $this;
    }
	
	/**
	 * @return array
	 */
	public function flush()
	{
		$headers = [];
		foreach($this->headers as $header => $values) {
			$headers[$header] = implode("; ", $values);
		}
		
		return $headers;
	}
}