<?php

namespace Xand\Component\Filesystem;

/**
 * Interface StreamInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface StreamInterface
{
    /**
     * @return static
     */
    public function close();

    /**
     * @return bool
     */
    public function isClosed();

    /**
     * @return bool
     */
    public function isSeekable();

    /**
     * @param     $offset
     * @param int $whence
     *
     * @return mixed
     */
    public function seek($offset, $whence = SEEK_SET);

    /**
     * @return bool
     */
    public function isReadable();

    /**
     * @param int $length
     *
     * @return string
     */
    public function read($length);

    /**
     * @return bool
     */
    public function isWriteable();

    /**
     * @param string $string
     *
     * @return static
     */
    public function write($string);

    /**
     * @return string
     */
    public function getContents();
	
    /**
     * @return static
     */
    public function detach();

    /**
     * @return int
     */
    public function getSize();

    /**
     * @return int
     */
    public function tell();

    /**
     * @return bool
     */
    public function eof();

    /**
     * @return static
     */
    public function rewind();

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function getMetadata($key = null);

    /**
     * @return mixed
     */
    public function truncate();
}