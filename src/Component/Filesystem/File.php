<?php

namespace Xand\Component\Filesystem;
use Xand\Component\Filesystem\Exception\FileNotFoundException;
use Xand\Core\io\Exception\FileAlreadyExistsException;

/**
 * Class File
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class File
{
	/**
	 * @param string
	 */
	protected $path;
	
	/**
	 * @param string|File
	 */
	protected $parent;
	
	/**
	 * @param string		$path
	 * @param string|File	$parent
	 */
	public function __construct($path, $parent = null)
	{
		$this->path = $path;
		$this->parent = $parent;
	}

    /**
     * @return string
     */
	public function getPath()
    {
        $path = [];

        if ($this->hasParent()) {
            $path[] = $this->parent->getPath();
        }

        $path[] = \rtrim(\preg_replace("/\\//", DIRECTORY_SEPARATOR, $this->path), "\\//");

        return \implode(DIRECTORY_SEPARATOR, $path);
    }
	
	/**
	 * @return StreamInterface
	 */
	public function getStream()
	{
		return new Stream(@\fopen($this->getPath(), 'a+'));
	}

    /**
     * @param $parent
     *
     * @return static
     */
	public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

	/**
	 * @return File
	 */
	public function getParent()
	{
		return $this->parent;
	}

    /**
     * @return bool
     */
	public function hasParent()
    {
        return null !== $this->parent;
    }

    /**
     * @return bool
     */
    public function isFile()
    {
        return \is_file($this->getPath());
    }

    /**
     * @return bool
     */
    public function isDirectory()
    {
        return \is_dir($this->getPath());
    }

    /**
     * @return bool
     */
    public function isDir()
    {
        return $this->isDirectory();
    }

	/**
	 * @return bool
	 */
	public function exists()
	{
		return \file_exists($this->getPath());
	}

    /**
     * @return bool
     * @throws \Exception
     */
	public function createNewFile()
	{
		try
		{
            if ($this->isFile())
                throw new \Exception(\sprintf(
                    'File % already exists.',
                    $this->getPath()
                ));

			$stream = $this->getStream();
			$stream->close();
			
			return true;
			
		} catch(\Exception $e) {

		}
		
		return false;
	}
	
	/**
	 * @return bool
	 */
	public function isHidden()
	{
		return "." == \substr($this->getFilename(), 0, 1);
	}
	
	/**
	 * @return string
	 */
	public function getExtension()
	{
		return false !== ($pos = \strrpos($this->path, '.'))
            ? \strtolower(\substr($this->path, $pos + 1)) : null;
	}
	
	/**
	 * @return bool
	 */
	public function mkdir()
	{
		if ($this->isDir())
			return false;
		
		if ( ! @\mkdir($this->getPath()))
			return false;
		
		return true;
	}

	public function mkdirs()
    {
        /** @var string[] */
        $parents = [];
        $path = \rtrim(\str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $this->getPath()), '\\/');

        $parents[] = $path;

        do
        {
            if (static::isAbsolutePath($path))
                break;

                if (   false !== ($pos = \strrpos($path, '\\'))
                    || false !== ($pos = \strrpos($path, '/'))) {
                    \array_unshift(
                        $parents,
                        \substr($path, 0, $pos)
                    );
                }

                $path = \dirname($path);
        } while(1);

        $i = 0;
        $count = \count($parents);
        $parent = null;

        do
        {
            /** @var File $parent */
            $parent = new static($parents[ $i ]);
            if (!$parent->isDirectory()) {
                 $parent->mkdir();
            }

            $i++;
        } while( $i < $count );

        return $this->isDirectory();
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isAbsolutePath($path)
    {
        return ':\\' == \substr($path, -2)
            || ':/'  == \substr($path, -2) || '/' == $path;
    }

    /**
     * @return bool
     */
	public function delete()
	{
		if ($this->isDir()) {
			try
			{
				foreach($this->getListFiles() as $result)
				{
					$file = new File($result);
					
					if (false === $file->delete())
						throw new \RuntimeException();
				}
			
				if (!@\rmdir ($this->getPath()))
					throw new \RuntimeException();
				
				return true;
			} catch(\Exception $e) {
				
			}
		} else if ($this->isFile()) {
			try
			{
                \unlink($this->path);
				
				return true;
			} catch(\Exception $e) {

			}
		}
		
		return false;
	}

    /**
     * @param string|File $dest
     *
     * @return bool
     * @throws \Xand\Core\io\Exception\FileAlreadyExistsException
     */
	public function renameTo($dest)
	{
	    $destFile = $dest instanceof File ? $dest : new File($dest);
	    if ($destFile->exists())
	        throw new FileAlreadyExistsException();

		return @\rename($this->getPath(), $destFile->getPath());
	}

    /**
     * @param string|File $dest
     *
     * @return bool
     * @throws \Xand\Core\io\Exception\FileAlreadyExistsException
     */
	public function copy($dest)
	{
	    $destFile = $dest instanceof File ? $dest : new File($dest);

        if ($destFile->exists())
            throw new FileAlreadyExistsException(\sprintf(
                "The file '%s' already exists",
                $destFile->getPath()
            ));

        if ($this->isDirectory())
            throw new \Exception(\sprintf(
                "Unable to copy directory"
            ));

        return @\copy($this->getPath(), $destFile->getPath());
	}

    /**
     * @return bool|string
     */
	public function getRealPath()
    {
        return \realpath($this->getPath());
    }


    /**
     * @param bool $filter
     *
     * @return array
     */
	public function getListFiles($filter = false)
	{
	    if (!$this->isDirectory())
	        throw new \LogicException(\sprintf(
	            "It is directory!?"
            ));

		$results = [];
		
		if (!($h = \opendir($this->getPath())))
			throw new \RuntimeException(\sprintf(
			    'Unable to open directory %s.',
                $this->path
            ));
		
		while(false !== ($filename = \readdir($h))) {
			try
			{
				if ("." == $filename || ".." == $filename)
					throw new \Exception();
				
				$rel = $this->getPath() . '/' . $filename;
				$file = new File($rel);

				if ($file->isDir()) {
                    foreach($file->getListFiles($filter) as $result) {
                        $results[] = $result;
                    }
                }

				$results[] = $rel;
			} catch(\Exception $e) {}
		}

		\closedir($h);
		
        if (\is_callable($filter)) {
		    $results = \array_filter($results, $filter);
        }

		return $results;
	}
	
	/**
	 * @return int
	 */
	public function getSize()
	{
		if ($this->isDirectory()) {

			$size = 0;
			
			foreach($this->getListFiles() as $path) {
                $size += (new File($path))->getSize();
            }
			
			return $size;
		} else if ($this->isFile()) {
			return \filesize($this->getPath());
		}
	}

    /**
     * @param null|int $time
     *
     * @return static
     */
	public function touch($time = null)
	{
	    if (!$this->exists())
	        throw new FileNotFoundException(\sprintf(
                "File %s not found",
                $this->getPath()
            ));

        return @\touch($this->getPath(), $time);
	}

	public function getLastModified()
	{
	    if (!$this->exists())
	        throw new FileNotFoundException(\sprintf(
	            "File %s not found",
                $this->getPath()
            ));

		return @\filemtime($this->getPath());
	}
}