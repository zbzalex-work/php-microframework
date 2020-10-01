<?php

namespace Xand\Component\Foundation;

/**
 * Interface BootableInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface RunnableInterface
{
    /**
     * @return mixed
     */
    public function run();
}