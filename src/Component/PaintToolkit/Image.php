<?php

namespace Xand\Component\PaintToolkit;
use Xand\Component\Filesystem\File;

/**
 * Class Image
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Image
{
	/**
	 * @var string
	 */
	protected $sourceOrigin;
	
	/**
	 * @var resource
	 */
	protected $resource;
	
	/**
	 * @return int
	 */
	protected $type;

    /**
     * Image constructor.
     *
     * @param null $sourceOrigin
     * @param      $resource
     * @param int  $type
     */
	public function __construct($sourceOrigin = null, $resource, $type = IMAGETYPE_JPEG)
	{
		$this->sourceOrigin = $sourceOrigin;
		$this->resource = $resource;
		if (false === array_search($type, $this->getImageTypes()))
			throw new \InvalidArgumentException();
		$this->type = $type;
	}
	
	/**
	 * @return string
	 */
	public function getSourceOrigin()
	{
		return $this->sourceOrigin;
	}
	
	/**
	 * @return int
	 */
	public function getWidth()
	{
		return imagesx($this->resource);
	}
	
	/**
	 * @return int
	 */
	public function getHeight()
	{
		return imagesy($this->resource);
	}
	
	/**
	 * @return int[]
	 */
	public function getSize()
	{
		return [
			$this->getWidth(),
			$this->getHeight()
		];
	}
	
	/**
	 * @return int[]
	 */
	public function getImageTypes()
	{
		return [
			IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF
		];
	}
	
	/**
	 * @param int $type
	 * 
	 * @throws \InvalidArgumentException
	 * 
	 * @return static
	 */
	public function setImageType($type)
	{
		if (false === array_search($type, $this->getImageType()))
			throw new \InvalidArgumentException();
		
		$this->type = $type;
		
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getImageType()
	{
		return $this->type;
	}

    /**
     * @param     $w
     * @param     $h
     * @param int $type
     *
     * @return \Xand\Component\PaintToolkit\Image
     */
	public static function create($w, $h, $type = IMAGETYPE_JPEG)
	{
		$dst = imagecreatetruecolor($w, $h);
		switch($type) {
			case IMAGETYPE_PNG:
				{
					imagesavealpha($dst, true);
					imagefill($dst, 0, 0, imagecolorallocatealpha($dst, 0, 0, 0, 127));
				}
				break;
		}
		
		return new static(null, $dst, $type);
	}

    /**
     * @param \Xand\Component\Filesystem\File $file
     *
     * @return \Xand\Component\PaintToolkit\Image
     * @throws \Exception
     */
	public static function createFromFile(File $file)
	{
		if (!$file->exists())
			throw new \Exception();

		if ( ! extension_loaded('exif'))
		    throw new \Exception('Extension exif is not available.');

		if (false === ($type = @exif_imagetype($file->getPath())))
			throw new \Exception('Unable to detect image type.');
		
		switch($type) {
			case IMAGETYPE_JPEG:
				{
					return new static($file->getPath(),
						imagecreatefromjpeg($file->getPath()),
						IMAGETYPE_JPEG);
				}
				break;
			case IMAGETYPE_PNG:
				{
					return new static($file->getPath(),
						imagecreatefrompng ($file->getPath()),
						IMAGETYPE_PNG);
				}
				break;
			case IMAGETYPE_GIF:
				{
					return new static($file->getPath(),
						imagecreatefromgif ($file->getPath()),
						IMAGETYPE_GIF);
				}
				break;
			default:
				{
					throw new \Exception('Unknown image type.');
				}
		}
	}
	
	/**
	 * @param string $dest
	 * @param int $quality
	 * @param int $filters
	 * 
	 * @return string
	 */
	public function toSource($dest = null, $quality = 70, $filters = null)
	{
		ob_start();
		
		switch($this->type) {
			case IMAGETYPE_JPEG:
				{
					imagejpeg($this->resource, $dest, $quality);
				}
				break;
			case IMAGETYPE_PNG:
				{
					imagepng ($this->resource, $dest, max(1, min($quality, 9)), $filters);
				}
				break;
			case IMAGETYPE_GIF:
				{
					imagegif ($this->resource, $dest);
				}
				break;
		}
		
		$data = ob_get_clean();
		
		return $data;
	}

    /**
     * @param null $dest
     * @param int  $quality
     * @param null $filters
     *
     * @return $this
     * @throws \Exception
     */
	public function save($dest = null, $quality = 70, $filters = null)
	{
		$dest = null === $dest ? $this->sourceOrigin : $dest;
		$file = new File($dest);
		if (false !== ($pos = strrpos($file->getPath(), '\\'))
		 || false !== ($pos = strrpos($file->getPath(), '/'))) {
			$destDir = new File(substr($file->getPath(), 0, $pos));
			if (!$destDir->isDir())
				throw new \Exception();
		}
		
		$this->toSource($dest, $quality, $filters);
		
		return $this;
	}
	
	/**
	 * @return resource
	 */
	public function toResource()
	{
		return $this->resource;
	}
	
	/**
	 * @param int $w
	 * @param int $h
	 * @param int $mX
	 * @param int $mY
	 * @param int $pX
	 * @param int $pY
	 * @param bool $crop
	 * 
	 * @return static
	 */
	public function resize($w, $h, $mX = 0, $mY = 0, $pX = 0, $pY = 0, $crop = false)
	{
		//origin w
		$ow = $this->getWidth();
		//origin h
		$oh = $this->getHeight();
		//ratio
		$r = $ow / $oh;
		if ($crop) {
			if ($ow > $oh) {
				$ow = ceil($ow-($ow * abs($r-$w/$h)));
			} else {
				$oh = ceil($oh-($ow * abs($r-$w/$h)));
			}
			
			$neww = $w;
			$newh = $h;
		}
		else {
			if ($w / $h > $r) {
				$neww = $h * $r;
				$newh = $h;
			} else {
				$newh = $w / $r;
				$neww = $w;
			}
		}
		
		$dst = static::create($neww, $newh, $this->type);
		
		imagecopyresampled(
			$dst->toResource(),
			$this->resource,
			$mX,
			$mY,
			$pX,
			$pY,
			$neww,
			$newh,
			$ow,
			$oh
		);
		
		$this->resource = $dst->toResource();
		
		return $this;
	}
	
	/**
	 * @param int $w    width
	 * @param int $h    height
	 * @param int $mX   margin from left
	 * @param int $mY   margin from top
	 * @param int $pX   padding from left
	 * @param int $pY   padding from top
	 * 
	 * @return static
	 */
	public function cut($w, $h, $mX = 0, $mY = 0, $pX = 0, $pY = 0)
	{
		$dst = static::create($w, $h, $this->type);
		
		imagecopy(
			$dst->toResource(),
			$this->resource,
			$mX,
			$mY,
			$pX,
			$pY,
			$w,
			$h
		);
		
		$this->resource = $dst->toResource();
		
		return $this;
	}
}
