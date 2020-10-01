<?php

namespace Xand\Component\I18n\Formatter;

/**
 * Interface FormatterInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface FormatterInterface
{
    /**
     * @param string                    $string
     * @param array<string, string>     $params
     *
     * @return string
     */
    public function format($string, array $params = []);
}