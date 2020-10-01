<?php


namespace Xand\Component\Filesystem\Filter;

/**
 * Class FilesOnlyFilter
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class DirectoriesOnlyFilter
{
    public function __invoke($filepath)
    {
        return \is_dir($filepath);
    }
}