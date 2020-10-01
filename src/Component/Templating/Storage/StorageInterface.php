<?php

namespace Xand\Component\Templating\Storage;

/**
 * Interface StorageInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface StorageInterface
{
    /**
     * @return mixed
     */
    public function getContent();
}