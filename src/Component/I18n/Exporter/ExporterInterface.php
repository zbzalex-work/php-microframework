<?php

namespace Xand\Component\I18n\Exporter;

/**
 * Interface ExporterInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ExporterInterface
{
    /**
     * @param string                    $file
     * @param array<string, string>     $translations
     *
     * @return mixed
     */
    public function export($file, array $translations = []);

    /**
     * @param string    $format
     *
     * @return bool
     */
    public function supports($format);
}