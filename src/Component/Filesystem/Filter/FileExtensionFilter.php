<?php


namespace Xand\Component\Filesystem\Filter;
use Xand\Component\Filesystem\File;

/**
 * Class FilesOnlyFilter
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FileExtensionFilter
{
    /**
     * @var string
     */
    protected $extension;

    /**
     * FilesOnlyFilter constructor.
     *
     * @param string $extension
     */
    public function __construct($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @param string $filepath
     *
     * @return bool
     */
    public function __invoke($filepath)
    {
        $file = new File($filepath);

        return $this->extension == $file->getExtension();
    }
}