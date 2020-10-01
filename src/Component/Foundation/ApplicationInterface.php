<?php

namespace Xand\Component\Foundation;
use Xand\Component\Foundation\Bundle\BundleInterface;

/**
 * Interface ApplicationInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ApplicationInterface extends RunnableInterface, BootableInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @return string
     */
    public function getRootDir();

    /**
     * @return string
     */
    public function getLogDir();

    /**
     * @return string
     */
    public function getCacheDir();

    /**
     * @return BundleInterface[]
     */
    public function registerBundles();

    /**
     * @return mixed
     */
    public function boot();

    /**
     * @return mixed
     */
    public function shutdown();

    /**
     * @return mixed
     */
    public function run();
}