<?php

namespace Xand\Component\Filesystem;

/**
 * Class InputStream
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class InputStream extends Stream
{
    /**
     * InputStream constructor.
     */
    public function __construct()
    {
		parent::__construct(@fopen('php://input', 'r'));
		
		if (false === ($h = @fopen('php://memory','r+')))
			throw new \RuntimeException();
		
		stream_copy_to_stream($this->h, $h);
		
		$this->h = $h;
		$this->rewind();
    }
}