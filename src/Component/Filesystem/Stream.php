<?php

namespace Xand\Component\Filesystem;

/**
 * Class Stream
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Stream implements StreamInterface
{
    /**
     * @var resource
     */
    protected $h;

    /**
     * Stream constructor.
     *
     * @param null $h
     */
    public function __construct($h = null)
    {
        $h = null === $h ? static::createTemp() : $h;
        if ( ! is_resource($h) || 'stream' != get_resource_type($h))
            throw new \RuntimeException("Failed to create stream");

        $this->h = $h;
    }

    /**
     * @param        $url
     * @param string $mode
     *
     * @return bool|resource
     */
    public static function create($url, $mode = "a+")
    {
        try
        {
            if (false === ($h = @fopen($url, $mode)))
                throw new \Exception();

            return $h;
        } catch(\Exception $e) {

        }
    }
	
	/**
     * @return resource|null
     */
    public static function createTemp()
    {
		return static::create("php://temp", "a+");
    }

    /**
     * @return static|\Xand\Component\Filesystem\StreamInterface
     * @throws \Exception
     */
    public function close()
    {
        if ($this->isClosed())
			throw new \Exception();
            
		if (!fclose($this->h))
			throw new \Exception();
		
        $this->h = null;
		
        return $this;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return null === $this->h || "stream" != \get_resource_type($this->h);
    }

    /**
     * @return resource
     */
    public function detach()
    {
        $h = $this->h;
        $this->h = null;

        return $h;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getSize()
    {
        if ($this->isClosed())
			throw new \Exception();
		
        $stat = @fstat($this->h);
		
        return isset($stat['size']) ? $stat['size'] : 0;
    }

    /**
     * @return int
     */
    public function tell()
    {
        return ! $this->isClosed() && false !== ($pos = @ftell($this->h)) ? $pos : 0;
    }

    /**
     * @return bool
     */
    public function eof()
    {
        return $this->isClosed() || @feof($this->h);
    }

    /**
     * @return bool
     */
    public function isSeekable()
    {
        return $this->getMetadata('seekable');
    }

    /**
     * @param int	$offset
     * @param int	$type
     * 
     * @return bool
     */
    public function seek($offset, $type = SEEK_SET)
    {
        if ( ! $this->isSeekable())
            throw new \RuntimeException();

        return -1 !== @fseek($this->h, $offset, $type);
    }

    /**
     * @return static
     */
    public function rewind()
    {
        $this->seek(0);

        return $this;
    }

    /**
     * @return bool
     */
    public function isWriteable()
    {
        return null != ($mode = $this->getMetadata('mode')) && ('r' != $mode[0]);
    }

    /**
     * @param string $data
     *
     * @return \Xand\Component\Filesystem\StreamInterface
     */
    public function write($data)
    {
        if (!$this->isWriteable())
            throw new \RuntimeException();

        if (!fwrite($this->h, $data))
			throw new \RuntimeException();
		
		return $this;
    }

    /**
     * @return bool
     */
    public function isReadable()
    {
        return null != ($mode = $this->getMetadata('mode')) && ('r' == $mode[0] || false !== strpos($mode, '+'));
    }

    /**
     * @param int $length
     *
     * @return bool|string
     * @throws \Exception
     */
    public function read($length = 1024)
    {
        if ( ! $this->isReadable())
            throw new \RuntimeException();
		
		if ($this->isClosed())
			throw new \Exception();
		
        if (false === ($contents = @fread($this->h, $length)))
			throw new \RuntimeException();
		
		return $contents;
    }

    /**
     * @return null|string
     * @throws \Exception
     */
    public function getContents()
    {
        if (!$this->isReadable())
            throw new \RuntimeException();
		
        $contents = null;
		
		do
		{
            $contents .= $this->read();
		} while(!$this->eof());
		
        return $contents;
    }
	
    /**
     * @param string|string	$key
     * 
     * @return array|bool
     */
    public function getMetadata($key = null)
    {
        return ! $this->isClosed() && false !== ($metadata = \stream_get_meta_data($this->h))
            ? (null !== $key && isset($metadata[$key]) ? $metadata[$key] : $metadata)
            : null;
    }

    /**
     * @param int $length
     *
     * @return $this
     * @throws \Exception
     */
	public function truncate($length = 0)
	{
		if ($this->isClosed())
			throw new \Exception();
		
		@\ftruncate($this->h, $length);
		
		return $this;
	}
}