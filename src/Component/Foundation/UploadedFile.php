<?php

namespace Xand\Component\Foundation;
use Xand\Component\Filesystem\Stream;
use Xand\Component\Filesystem\StreamInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class UploadedFile
{
    protected $tempname;
	protected $filename;
	protected $mimeType;
	protected $size;
	protected $errorCode;

    /**
     * @param string	$tempname
     * @param string	$filename
     * @param string	$mimeType
     * @param int		$size
     * @param int		$errorCode
     */
    public function __construct($tempname, $filename, $mimeType, $size, $errorCode)
    {
        $this->tempname = $tempname;
        $this->filename = $filename;
        $this->mimeType = $mimeType;
        $this->size = $size;
        $this->errorCode = $errorCode;
    }

    /**
     * @return \Xand\Component\Filesystem\Stream
     */
    public function getStream()
    {
		if (false === ($h = @fopen($this->tempname, "r")))
			throw new \RuntimeException( sprintf("Unable to read file: %s", $this->tempname));
		
        return new Stream($h);
    }

    /**
     * @return string
     */
    public function getTempname()
    {
        return $this->tempname;
    }

    /**
     * @return string
     */
    public function getClientFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getClientMimetype()
    {
        return $this->mimeType;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return bool
     */
    public function isOk()
    {
        return 0 == $this->errorCode;
    }
	
	/**
	 * @return string|null
	 */
	public function getExtension()
	{
		return false !== ($pos = strrpos($this->filename, ".")) ? substr($this->filename, $pos + 1) : null;
	}
	
    /**
     * @param string	$dest
     * 
     * @throws \RuntimeException
     * 
     * @return static
     */
    public function save($dest)
    {
        if (!@move_uploaded_file($this->tempname, $dest))
            throw new \RuntimeException(sprintf("Unable to save file: %s, %s", $this->tempname, $dest));

        return $this;
    }
}