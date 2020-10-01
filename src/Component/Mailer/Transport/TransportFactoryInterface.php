<?php

namespace Xand\Component\Mailer\Transport;

/**
 * Interface TransportFactoryInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface TransportFactoryInterface
{
    /**
     * @param Dsn $dsn
     *
     * @return bool
     */
    public function supports(Dsn $dsn);
}