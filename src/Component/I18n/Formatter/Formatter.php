<?php

namespace Xand\Component\I18n\Formatter;

/**
 * Class Formatter
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Formatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format($string, array $params = [])
    {
        return preg_replace_callback('/\:([^ ]+)/i', function($matches) use($params) {
            list($placeholder, $key) = $matches;
            return isset($params[ $key ]) ? $params[ $key ] : $placeholder;
        }, $string);
    }
}