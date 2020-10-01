<?php

namespace Xand\Component\Form;
use Xand\Component\Form\Exception\AlreadySubmittedException;
use Xand\Component\Form\Event\FormEvent;
use Xand\Component\Foundation\ServerRequest;
use Xand\Component\EventDispatcher\EventDispatcherInterface;
use Xand\Component\EventDispatcher\EventDispatcher;

/**
 * Class Form
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Form implements FormInterface, \ArrayAccess
{
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var ResolvedTypeInterface
	 */
	protected $resolvedType;

    /**
     * @var string
     */
	protected $action;

    /**
     * @var string
     */
	protected $method;
	
	/**
	 * @var \Xand\Component\Form\FormConfig
	 */
	protected $config;
	
	/**
	 * @var FormFactoryInterface
	 */
	protected $factory;
	
	/**
	 * @var RequestHandlerInterface
	 */
	protected $handler;
	
	/**
	 * @var FormInterface[]
	 */
	protected $children;
	
	/**
	 * @var array
	 */
	protected $data;
	
	/**
	 * @var bool
	 */
	protected $submitted = false;
	
	/**
	 * @var array
	 */
	protected $errors = [];

    /**
     * @var \Xand\Component\EventDispatcher\EventDispatcherInterface
     */
	protected $dispatcher;

    /**
     * Form constructor.
     *
     * @param                                                          $name
     * @param \Xand\Component\Form\ResolvedTypeInterface               $resolvedType
     * @param                                                          $action
     * @param                                                          $method
     * @param array                                                    $options
     * @param \Xand\Component\Form\FormFactoryInterface                $factory
     * @param \Xand\Component\Form\RequestHandlerInterface             $handler
     * @param \Xand\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     */
	public function __construct($name, ResolvedTypeInterface $resolvedType, $action, $method, FormConfig $config,
                                FormFactoryInterface $factory, RequestHandlerInterface $handler,
                                EventDispatcherInterface $dispatcher)
	{
		$this->name = $name;
		$this->resolvedType = $resolvedType;
		$this->action = $action;
		$this->method = $method;
		$this->config = $config;
		$this->factory = $factory;
		$this->handler = $handler;
		$this->dispatcher = $dispatcher;
		$this->children = [];
	}
	
	/**
	 * @param RequestHandlerInterface $handler
	 * 
	 * @return static
	 */
	public function setRequestHandler(RequestHandlerInterface $handler)
	{
		$this->handler = $handler;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

    /**
     * @param string $name
     *
     * @return static
     */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * @param string $action
	 * 
	 * @return static
	 */
	public function setAction($action)
	{
		$this->action = $action;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	/**
	 * @param string $method
	 * 
	 * @return static
	 */
	public function setMethod($method)
	{
		$this->method = strtoupper($method);
		
		return $this;
	}

    /**
     * @return \Xand\Component\Form\FormConfig
     */
	public function getConfig()
	{
		return $this->config;
	}

    /**
     * @return \Xand\Component\EventDispatcher\EventDispatcherInterface
     */
	public function getEventDispatcher()
	{
		return $this->dispatcher;
	}
	
	/**
	 * @return FormInterface[]
	 */
	public function children()
	{
		return $this->children;
	}
	
	/**
	 * @param string|FormInterface $child
	 * @param string|null $type
	 * @param array $options
	 * 
	 * @return static
	 */
	public function add($child, $type = null, array $options = [])
	{
		if (is_string($child)) {
			$this->children[ $child ] = $this->factory->create($child, $type, $options)->getForm();
		} else if ($child instanceof FormInterface) {
		    /** @var \Xand\Component\Form\FormInterface $child */
			$this->children[ $child->getName() ] = $child;
		}
		
		return $this;
	}
	
	/**
	 * @param string $name
	 * 
	 * @return bool
	 */
	public function has($name)
	{
		return isset($this->children[$name]);
	}

    /**
     * @param string $name
     *
     * @return mixed|\Xand\Component\Form\FormInterface
     * @throws \Exception
     */
	public function get($name)
	{
		if (!$this->has($name))
			throw new \Exception();
		
		return $this->children[$name];
	}
	
	/**
	 * @param string $name
	 * 
	 * @return bool
	 */
	public function offsetExists($name)
	{
		return $this->has($name);
	}
	
	/**
	 * @param string    $name
	 * @param string    $value
	 */
	public function offsetSet($name, $value)
    {
        // TODO: ..
    }

    /**
     * @param mixed $name
     *
     * @return mixed|\Xand\Component\Form\FormInterface
     * @throws \Exception
     */
	public function offsetGet($name)
	{
		return $this->get($name);
	}
	
	/**
	 * @param string $name
	 */
	public function offsetUnset($name) {}

    /**
     * @param \Xand\Component\Foundation\ServerRequest|null $request
     *
     * @return static
     * @throws \Exception
     */
	public function handleRequest(ServerRequest $request = null)
	{
		$request = null === $request ? ServerRequest::createFromGlobals() : $request;
		\call_user_func($this->handler, $this, $request);
		
		return $this;
	}

    /**
     * @param null $submittedData
     *
     * @return static
     * @throws \Xand\Component\Form\Exception\AlreadySubmittedException
     */
	public function submit($submittedData = null)
	{
		if ($this->submitted)
			throw new AlreadySubmittedException();
		
		$this->submitted = true;
		
		$event = new FormEvent($this, $submittedData);
		$this->dispatcher->dispatch(FormEvents::SUBMIT, $event);
		/* @var array */
		$submittedData = $event->getData();
		
		if (is_array($submittedData)) {
			foreach($this->children as $name => $child) {
				try
				{
					if ( ! isset($submittedData[$name]))
						throw new \Exception();
					
					$child->submit($submittedData[$name]);
				} catch(\Exception $e) {
					
				}
			}
		}
		
		$this->data = $submittedData;
		
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isSubmitted()
	{
		return $this->submitted;
	}
	
	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/**
	 * @param string	$message
	 * 
	 * @return static
	 */
	public function addError($message)
	{
		$this->errors[] = $message;
		
		return $this;
	}
	
	/**
	 * @return string[]
	 */
	public function getErrors()
	{
		/* @var string[] */
		$errors = $this->errors;
		
		foreach($this->children as $name => $child)
			foreach($child->getErrors() as $message)
				$errors[] = $message;
		
		return $errors;
	}
	
	public function hasErrors()
	{
		return 0 != count($this->getErrors());
	}
	
	/**
	 * @return static
	 */
	public function clearErrors()
	{
		$this->errors = [];
		
		return $this;
	}

    /**
     * @return string|null
     */
	public function getLastError()
	{
		if ($this->hasErrors()) {
			$errors = $this->getErrors();
			
			return \array_pop($errors);
		}

		return null;
	}

    /**
     * @return bool
     */
	public function isValid()
	{
		if (!$this->submitted)
			throw new \LogicException();
		
		return 0 == count($this->getErrors()) && false != $this->data;
	}
	
	/**
	 * @param FormView $parent
	 * 
	 * @return FormView
	 */
	public function createView(FormView $parent = null)
	{
		$view = new FormView();
		$view->parent = null === $parent ? new FormView() : $parent;
		$this->resolvedType->buildView($view, $this);
		
		foreach($this->children as $name => $child) {
		    /** @var \Xand\Component\Form\FormInterface $child */
			$view->children[$name] = $child->createView($view);
		}
		
		return $view;
	}
}