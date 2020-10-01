<?php

namespace Xand\Component\Foundation;
use Xand\Component\DependencyInjection\ContainerBuilder;
use Xand\Component\Foundation\Exception\AlreadyBootedException;

/**
 * Class Application
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class Application implements ApplicationInterface
{
    /**
     * @var string
     */
    protected $rootDir;

	/**
	 * @var \Xand\Component\DependencyInjection\ContainerInterface
	 */
	protected $container;

    /**
     * @var \Xand\Component\Foundation\Bundle\BundleInterface[]
     */
	protected $bundles;

	/**
	 * @var bool
	 */
    protected $booted = false;

    /**
     * @return string
     */
	public function getName()
	{
		return "";
	}

    /**
     * @return string
     */
	public function getVersion()
	{
		return "1.0.0";
	}

    /**
     * @return string
     */
    public function getRootDir()
    {
        if (null === $this->rootDir) {
            $this->rootDir = \dirname((new \ReflectionObject($this))->getFileName());
        }

        return $this->rootDir;
    }

    /**
     * @return string
     */
	public function getLogDir()
	{
		return $this->getRootDir() . "/var/log";
	}

    /**
     * @return string
     */
	public function getCacheDir()
	{
		return $this->getRootDir() . "/var/cache";
	}

    /**
     * @return \Xand\Component\Foundation\Bundle\BundleInterface[]
     */
	public function getBundles()
    {
        return $this->bundles;
    }

    /**
     * @return void
     */
	protected function initBundles()
    {
        $this->bundles = [];
        foreach($this->registerBundles() as $bundle) {
            $this->bundles[ $bundle->getName() ] = $bundle;
        }
    }

    /**
     * Build container and register all extensions.
     *
     * @throws \Exception
     */
	protected function build()
    {
        /** @var ContainerBuilder $container */
        $this->container = new ContainerBuilder();

        foreach($this->bundles as $bundle) {
            /** @var \Xand\Component\Foundation\Bundle\Bundle $bundle */
            /** @var \Xand\Component\DependencyInjection\Extension\ExtensionInterface $extension */
            if (null !== ($extension = $bundle->getExtension())) {
                $this->container->registerExtension($extension);
            }
        }

        $this->container->set("app", $this);
        $this->container->load();
    }
	
    /**
     * Bundles which are used the application.
     *
     * @return \Xand\Component\Foundation\Bundle\BundleInterface[]
     */
    public function registerBundles()
    {
        return [];
    }

    /**
     * Booting the application and all her components
     *
     * @throws \Xand\Component\Foundation\Exception\AlreadyBootedException
     */
    public function boot()
    {
        if ($this->booted)
            throw new AlreadyBootedException();

        $this->initBundles();

        /** @noinspection PhpUnhandledExceptionInspection */
		$this->build();

		foreach($this->bundles as $bundle) {
		    /** @var \Xand\Component\Foundation\Bundle\Bundle $bundle */
		    $bundle->setContainer($this->container);
            $bundle->boot();
        }
		
        $this->booted = true;
    }

    /**
     * Shutting down the application and all bundles.
     *
     * @throws \Exception
     */
    public function shutdown()
    {
        if ( ! $this->booted)
            throw new \Exception();

        foreach($this->bundles as $bundle) {
            /** @var \Xand\Component\Foundation\Bundle\Bundle $bundle */
            $bundle->shutdown();
            $bundle->setContainer(null);
        }

        $this->booted = false;
    }

    /**
     * @return \Xand\Component\Foundation\KernelInterface
     */
    public function getKernel()
    {
        return $this->container->get("kernel");
    }

    /**
     * Run the application
     *
     * @return mixed|void
     */
    public function run()
    {
        try
        {
            $this->boot();
            $this->getKernel()->handleRequest();
        } catch(AlreadyBootedException $e) {

        }
    }
}