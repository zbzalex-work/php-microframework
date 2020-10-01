<?php

namespace Xand\Component\Templating;
use Xand\Component\Templating\Loader\LoaderInterface;
use Xand\Component\Templating\Helper\HelperInterface;
use Xand\Component\EventDispatcher\EventDispatcher;
use Xand\Component\EventDispatcher\EventDispatcherInterface;
use Xand\Component\Templating\Storage\FileStorage;
use Xand\Component\Templating\Storage\StorageInterface;
use Xand\Component\Templating\Storage\StringStorage;

/**
 * Class PhpEngine
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class PhpEngine implements EngineInterface, \ArrayAccess
{
	/**
	 * @var EventDispatcherInterface
	 */
	protected $dispatcher;
	
	/**
	 * @var TemplateNameParserInterface
	 */
	protected $parser;
	
	/**
	 * @var LoaderInterface
	 */
	protected $loader;
	
	/**
	 * @var array
	 */
	protected $globals;
	
	/**
	 * @var HelperInterface[]
	 */
	protected $helpers;

    /**
     * @var object
     */
	private $evalStorage;
	
	/**
	 * @var array
	 */
	private $evalParameters;

	protected $cache;
	
	/**
	 * @param EventDispatcherInterface $dispatcher
	 * @param LoaderInterface $loader
	 * @param TemplateNameParserInterface $parser
	 */
	public function __construct(LoaderInterface $loader, EventDispatcherInterface $dispatcher = null,
                                TemplateNameParserInterface $parser = null)
	{
		$this->loader = $loader;
		$this->dispatcher = null === $dispatcher ? new EventDispatcher() : $dispatcher;
		$this->parser = null === $parser ? new TemplateNameParser() : $parser;
		$this->globals = [];
		$this->helpers = [];
		$this->cache = [];
	}
	
	/**
	 * @return EventDispatcherInterface
	 */
	public function getEventDispatcher()
	{
		return $this->dispatcher;
	}
	
	/**
	 * @return LoaderInterface
	 */
	public function getLoader()
	{
		return $this->loader;
	}
	
	/**
	 * @param string $key
	 * 
	 * @return bool
	 */
	public function hasGlobal($key)
	{
		return isset($this->globals[$key]);
	}
	
	/**
	 *	@param string $key
	 *	@param string $value
	 *	
	 *	@return static
	 */
	public function setGlobal($key, $value)
	{
		$this->globals[$key] = $value;
		
		return $this;
	}
	
	/**
	 * @param array $globals
	 * 
	 * @return static
	 */
	public function setGlobals(array $globals)
	{
		$this->globals = $globals;
		
		return $this;
	}
	
	/**
	 * @param string $key
	 * 
	 * @return static
	 */
	public function removeGlobal($key)
	{
		if ($this->hasGlobal($key)) unset($this->globals[$key]);
		
		return $this;
	}
	
	/**
	 * @param string $name
	 * 
	 * @return bool
	 */
	public function hasHelper($name)
	{
		return isset($this->helpers[$name]);
	}
	
	/**
	 * @param HelperInterface $helper
	 * 
	 * @return static
	 */
	public function addHelper(HelperInterface $helper)
	{
		$this->helpers[ $helper->getName() ] = $helper;
		
		return $this;
	}
	
	/**
	 * @param string $name
	 * 
	 * @return static
	 */
	public function removeHelper($name)
	{
		if ($this->hasHelper($name)) {
		    unset($this->helpers[$name]);
        }
		
		return $this;
	}

    /**
     * @param string $name
     *
     * @return mixed|\Xand\Component\Templating\Helper\HelperInterface
     */
	public function getHelper($name)
    {
        if ($this->hasHelper($name)) {
            return $this->helpers[$name];
        }
    }

    /**
     * @param string $filename
     *
     * @return mixed
     * @throws \Exception
     */
	protected function load($filename)
	{
	    /** @var Template $template */
		$template = $this->parser->parse($filename);

		if (!$this->supports($template))
			throw new \RuntimeException(\sprintf(
			    "Unsupported template: %s",
                $filename
            ));

		if (null === ($storage = $this->loader->load($template->getName())))
			throw new \Exception(\sprintf(
			    "Failed to get storage for template: %s",
                $filename
            ));

		return $storage;
	}

    /**
     * @param string $name
     * @param array  $parameters
     *
     * @return bool|mixed|string
     * @throws \Exception
     */
	public function render($name, array $parameters = [])
	{
        $hashCode = \hash("crc32b", $name);

        if (isset($this->cache[$hashCode])) {
            $storage = $this->cache[$hashCode];
        } else {
            $storage = $this->load($name);
            $this->cache[$hashCode] = $storage;
        }

        /** @var array $params */
        $parameters = \array_merge($this->globals, $parameters);
        if (false === ($content = $this->_eval($storage, $parameters)))
            throw new \Exception(\sprintf("Unable to eval template: %s", $name));

        return $content;
	}

    /**
     * @param \Xand\Component\Templating\Storage\StorageInterface $storage
     * @param array                                               $parameters
     *
     * @return bool|string
     * @throws \Exception
     */
	protected function _eval(StorageInterface $storage, array $parameters = [])
	{
		$this->evalStorage = $storage;
		$this->evalParameters = $parameters;

		// remove local variables
		unset(
		    $storage,
            $parameters
        );

		if (isset($this->evalParameters['this']))
		    throw new \Exception("Invalid parameter: this");
		if (isset($this->evalParameters['view']))
		    throw new \Exception("Invalid parameter: view");
		
		$view = $this;
		
		if ($this->evalStorage instanceof FileStorage) {

			\extract($this->evalParameters, EXTR_SKIP);
			$this->evalParameters = null;
			\ob_start();

			require $this->evalStorage->getContent();
			
			$this->evalStorage = null;
			
			return \ob_get_clean();
		} else if ($this->evalStorage instanceof StringStorage) {
		    return $this->evalStorage->getContent();
        }
		
		return false;
	}
	
	/**
	 *	@param Template $template
	 *	
	 *	@return bool
	 */
	public function supports(Template $template)
	{
		return "php" == $template->getEngine();
	}

    /**
     * @param $name
     *
     * @return mixed|\Xand\Component\Templating\Helper\HelperInterface
     * @throws \Exception
     */
    public function __get($name)
    {
        return $this->getHelper($name);
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
	public function offsetExists($offset)
    {
	    return $this->hasHelper($offset);
    }
	
	/**
	 * @param string $offset
	 * @param string $val
	 * 
	 * @return void
	 */
	public function offsetSet($offset, $val) {}

    /**
     * @param string $name
     *
     * @return mixed|\Xand\Component\Templating\Helper\HelperInterface
     * @throws \Exception
     */
	public function offsetGet($name)
	{
		return $this->__get($name);
	}
	
	/**
	 * @param string $offset
	 * 
	 * @return void
	 */
	public function offsetUnset($offset) {}
}