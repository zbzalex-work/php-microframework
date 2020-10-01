<?php

namespace Xand\Component\Foundation\Bundle;
use Xand\Component\Foundation\BootableInterface;

/**
 * Interface BundleInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface BundleInterface extends BootableInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot();

    /**
     * @return mixed
     */
    public function shutdown();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getNamespace();

    /**
     * @return string
     */
    public function getExtensionClass();

    /**
     * @return string
     */
    public function getPath();
}