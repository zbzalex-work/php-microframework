<?php


namespace Xand\Component\Filesystem\Filter;

/**
 * Class FilesOnlyFilter
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class PatternFilter
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * PatternFilter constructor.
     *
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @param string $filepath
     *
     * @return false|int
     */
    public function __invoke($filepath)
    {
        return \preg_match("/" . $this->pattern . "/i", $filepath);
    }
}