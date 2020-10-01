<?php

namespace Xand\Component\Foundation;

/**
 * Interface BootableInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface BootableInterface
{
    /**
     * @return mixed
     */
    public function boot();
}