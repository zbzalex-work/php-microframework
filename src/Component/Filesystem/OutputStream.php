<?php

namespace Xand\Component\Filesystem;

/**
 * Class OutputStream
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class OutputStream extends Stream
{
    /**
     * @return static
     * @throws \Exception
     */
    public function flush()
    {
        if (false === ($output = @\fopen('php://output', 'a+')))
            throw new \RuntimeException();
		
        $this->rewind();
		
        \stream_copy_to_stream($this->h, $output);
        $this->close();
		
        $this->h = $output;
		
        return $this;
    }
}