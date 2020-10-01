<?php

namespace Xand\Component\Foundation;
use Xand\Component\Filesystem\OutputStream;
use Xand\Component\Filesystem\StreamInterface;
use Xand\Component\Foundation\Http\Headers;

/**
 * Class Response
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Response
{
    /**
     * @var int
     */
    protected $status;
	
    /**
     * @var null|string
     */
    protected $reasonPhrase = null;
	
    /**
     * @var string[]
     */
    protected $reasonPhrases = [
        200 => 'OK',
        302 => 'Redirected',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        503 => 'Service Temporaily Unavailable'
    ];
	
    /**
     * @var double
     */
    protected $protocolVersion;
	
    /**
     * @var Headers
     */
    protected $headers;
	
    /**
     * @var StreamInterface
     */
    protected $body;
	
    /**
     * @param string    $content
     * @param array     $headers
     */
    public function __construct($content = null, array $headers = [])
    {
        $this->body = new OutputStream();

		if (null !== $content) {
            $this->body->write($content);
        }
		
        $this->headers = new Headers($headers);
        $this->protocolVersion = '1.0';
		$this->status = 200;
    }

    /**
     * @param int $status
     * @param null|string $reasonPhrase
     *
     * @return static
     */
    public function setStatus($status, $reasonPhrase = null)
    {
        $this->status = $status;
        $this->reasonPhrase = $reasonPhrase;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return null === $this->reasonPhrase
			? (isset($this->reasonPhrases[$this->status])
				   ? $this->reasonPhrases[$this->status] : null)
			: $this->reasonPhrase;
    }

    /**
     * @return StreamInterface
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param StreamInterface $body
     *
     * @return static
     */
    public function setBody(StreamInterface $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param double $version
     *
     * @return static
     */
    public function setProtocolVersion($version)
    {
        $this->protocolVersion = $version;

        return $this;
    }

    /**
     * @return double
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }
	
	/**
	 * @return Headers
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

    /**
     * @param Headers $headers
     *
     * @return static
     */
	public function setHeaders(
	    Headers $headers
    )
    {
        $this->headers = $headers;

        return $this;
    }
	
	/**
	 * @param string $header
	 * @param array $values
	 * 
	 * @return static
	 */
	public function sendHeaders($header = null, $values = null)
	{
		$values = null === $header ? $this->headers->getHeaders() : $values;
		
		foreach($values as $h => $value) {
			if (is_array($value)) {
				$this->sendHeaders($h, $value);
			}
			else
                header(sprintf("%s:%s", $header, $value), false);
		}
		
		return $this;
	}
	
	/**
	 * @return static
	 */
	public function sendContent()
	{
		if ($this->body instanceof OutputStream) {
            $this->body->flush();
        }
		
		return $this;
	}
	
    /**
	 * @throws \RuntimeException
	 * 
     * @return static
     */
    public function send()
    {
        if (headers_sent())
            throw new \RuntimeException("Headers already sent");
		
        header(sprintf(
			"HTTP/%1.01f %d %s",
			$this->protocolVersion,
			$this->status,
			$this->getReasonPhrase()
		), true, $this->status);
		
		$this->sendHeaders();
		$this->sendContent();

        return $this;
    }
}