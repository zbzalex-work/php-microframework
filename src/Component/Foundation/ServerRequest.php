<?php

namespace Xand\Component\Foundation;
use Xand\Component\Filesystem\InputStream;
use Xand\Component\Filesystem\StreamInterface;
use Xand\Component\Foundation\Http\Headers;
use Xand\Component\Foundation\Http\Uri;

/**
 * Class ServerRequest
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ServerRequest
{
    /**
     * @var string
     */
    protected $protocolVersion;
	
    /**
     * @var \Xand\Component\Foundation\Http\Uri
     */
    protected $uri;

    /**
     * @var StreamInterface
     */
    protected $body;

    /**
     * @var \Xand\Component\Foundation\Http\Headers
     */
    protected $headers;

    /**
     * @var array
     */
    protected $queryParams;
	
    /**
     * @var array
     */
    protected $uploadedFiles;

    /**
     * @var array
     */
    protected $cookieParams;

    /**
     * @var array
     */
    protected $serverParams;
	
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var string
     */
    protected $method;
	
	/**
	 * @var string
	 */
	protected $parsedBody;

    /**
	 * @param \Xand\Component\Foundation\Http\Uri $uri
	 * @param string $method
	 * @param StreamInterface $body
     * @param array $serverParams
     * @param array $headers
	 * @param array $uploadedFiles
	 * @param array $cookieParams
	 * @param array $queryParams
	 * @param string $parsedBody
	 * @param array $attributes
	 * @param string $protocolVersion
     */
    public function __construct(Uri $uri = null, $method = null, StreamInterface $body = null,
                                array $serverParams = [], array $headers = [], array $uploadedFiles = [],
                                array $cookieParams = [], array $queryParams = [], $parsedBody = null,
                                array $attributes = [], $protocolVersion = '1.1')
    {
		$this->serverParams = $serverParams;
		$this->uri = $uri;
		$this->headers = new Headers($headers);
		$this->uploadedFiles = $uploadedFiles;
		$this->body = $body;
		$this->method = $method;
		$this->cookieParams = $cookieParams;
		$this->queryParams = $queryParams;
		$this->parsedBody = $parsedBody;
		$this->attributes = $attributes;
		$this->protocolVersion = $protocolVersion;
    }

    /**
     * @return \Xand\Component\Foundation\ServerRequest
     * @throws \Exception
     */
    public static function createFromGlobals()
    {
		$headers = ServerRequestInflector::getHeaders($_SERVER);
        $body = new InputStream();
        $parsedBody = $body->getContents();
		
        switch($_SERVER['REQUEST_METHOD']) {
				case "POST":
					{
						$parsedBody = $_POST;
					}
					break;
				default:
					{
						try
						{
							if (isset($headers['content-type']) && $headers['content-type']
                                && !preg_match('/^application\/json/i', $headers['content-type'][0])
                                || !isset($headers['content-type']))
								throw new \Exception();

                            /** @var array $data */
							$data = \json_decode($parsedBody, true);
							if (JSON_ERROR_NONE != json_last_error())
							    throw new \Exception();
                            $parsedBody = $data;
						} catch(\Exception $e) {
							// TODO: ..
						}
					}
        }

        $uri = new Uri($_SERVER['REQUEST_URI']);
        $uri->setScheme(isset($_SERVER['HTTPS']) && "on" == $_SERVER['HTTPS']
            ? "https"
            : $_SERVER['REQUEST_SCHEME']);
        $uri->setHost($_SERVER['HTTP_HOST']);

        return new static($uri, $_SERVER['REQUEST_METHOD'], $body, $_SERVER, $headers,
            ServerRequestInflector::getUploadedFiles($_FILES), $_COOKIE, $_GET, $parsedBody);
    }
	
	/**
	 * @return array
	 */
	public function getServerParams()
	{
		return $this->serverParams;
	}
	
	/**
	 * @return array
	 */
	public function getUploadedFiles()
	{
		return $this->uploadedFiles;
	}
	
	/**
	 * @param array $params
	 * 
	 * @return static
	 */
	public function setQueryParams(array $params)
	{
		$this->queryParams = $params;
		
		return $this;
	}
	
	/** 
	 * @return array
	 */
	public function getQueryParams()
	{
		return $this->queryParams;
	}
	
	/** 
	 * @return array
	 */
	public function getCookieParams()
	{
		return $this->cookieParams;
	}
	
    /**
     * @return float
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @param double	$version
     * 
     * @return static
     */
    public function setProtocolVersion($version)
    {
        $this->protocolVersion = $version;

        return $this;
    }
	
    /**
     * @param string $method
     *
     * @return static
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
	
    /**
     * @param string	$key
	 * @param string	$default
     * 
     * @return string|null
     */
    public function getAttribute($key, $default = null)
    {
        return $this->hasAttribute($key)
			? $this->attributes[$key]
			: $default;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string	$key
     *
     * @return bool
     */
    public function hasAttribute($key)
    {
        return isset($this->attributes[$key]);
    }
	
    /**
     * @param string	$key
     * @param string	$value
     * 
     * @return static
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[ $key ] = $value;

        return $this;
    }

    /**
     * @param string	$key
     * 
     * @return static
     */
    public function removeAttribute($key)
    {
        if ($this->hasAttribute($key))
			unset($this->attributes[ $key ]);
		
        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return bool
     */
    public function isXmlHttpRequest()
    {
		if (!$this->getHeaders()->has('x-requested-with'))
			return false;
		
		return 'xmlhttprequest' == \strtolower($this->getHeaders()->get('x-requested-with')[0]);
    }
	
    /**
     * @return bool
     */
    public function isAjax()
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return 'POST' == $this->method;
    }

    /**
     * @return \Xand\Component\Foundation\Http\Uri
     */
	public function getUri()
	{
		return $this->uri;
	}

    /**
     * @param \Xand\Component\Foundation\Http\Uri $uri
     *
     * @return static
     */
	public function setUri(Uri $uri)
	{
		$this->uri = $uri;
		
		return $this;
	}
	
	/**
	 * @return StreamInterface
	 */
	public function getBody()
	{
		return $this->body;
	}
	
	/**
	 * @param StreamInterface	$body
	 *
	 * @return static
	 */
	public function setBody(StreamInterface $body)
	{
		$this->body = $body;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getParsedBody()
	{
		return $this->parsedBody;
	}
	
	/**
	 * @param string	$data
	 * 
	 * @return static
	 */
	public function setParsedBody($data)
	{
		$this->parsedBody = $data;
		
		return $this;
	}
	
	/**
	 * @return Headers
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

    /**
     * @return string|false
     */
	public function getClientIp()
    {
        /** @var array */
        $serverParams = $this->getServerParams();

        foreach([
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
                ] as $key) {

            if (isset($serverParams[ $key ])) return $serverParams[ $key ];

        }

        return false;
    }
}