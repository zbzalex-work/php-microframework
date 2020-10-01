<?php


namespace Xand\Component\Filesystem\Filter;

/**
 * Class FilesOnlyFilter
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FilesOnlyFilter
{
    public function __invoke($filepath)
    {
        return \is_file($filepath);
    }
}