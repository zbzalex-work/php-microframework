<?php

namespace Xand\Component\I18n\Importer;

use Xand\Component\I18n\Store\StoreInterface;

/**
 * Interface ImporterInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ImporterInterface
{
    /**
     * @param string            $file
     * @param StoreInterface    $store
     *
     * @return mixed
     */
    public function import($file, StoreInterface $store);

    /**
     * @param string    $format
     *
     * @return bool
     */
    public function supports($format);
}