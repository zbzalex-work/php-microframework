<?php

namespace Xand\Component\Form;
use Xand\Component\EventDispatcher\EventDispatcherInterface;
use Xand\Component\EventDispatcher\EventDispatcher;

/**
 * Class FormBuilder
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormBuilder implements FormBuilderInterface
{
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 *	@var ResolvedTypeInterface
	 */
	protected $resolvedType;
	
	/**
	 * @var EventDispatcherInterface
	 */
	protected $dispatcher;

	/**
	 * @var RequestHandler
	 */
	protected $handler;

	/**
	 * @var FormFactoryInterface
	 */
	protected $factory;
	
	/**
	 *	@var string
	 */
	protected $action;

	/**
	 *	@var string
	 */
	protected $method = "POST";
	
	/**
	 * @var array
	 */
	protected $children;

    /**
     * @var \Xand\Component\Form\FormConfig
     */
	protected $config;
	
	/**
	 * @param string $name
	 * @param string $resolved_type
	 * @param FormFactoryInterface $factory
	 * @param EventDispatcherInterface $dispatcher
	 * @param RequestHandlerInterface $requestHandler
	 */
	public function __construct($name, ResolvedTypeInterface $resolvedType, FormConfig $config,
                                FormFactoryInterface $factory, RequestHandlerInterface $handler = null,
                                EventDispatcherInterface $dispatcher = null)
	{
		$this->name = $name;
		$this->resolvedType = $resolvedType;
		$this->config = $config;
		$this->factory = $factory;
		$this->handler = null === $handler ? new RequestHandler() : $handler;
		$this->dispatcher = null === $dispatcher ? new EventDispatcher() : $dispatcher;
		$this->children = [];
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
	 * @return EventDispatcherInterface
	 */
	public function getEventDispatcher()
	{
		return $this->dispatcher;
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
     * @param       $name
     * @param       $type
     * @param array $options
     *
     * @return \Xand\Component\Form\FormBuilderInterface
     */
	public function create($name, $type, array $options = [])
	{
		return $this->factory->create($name, $type, $options);
	}
	
	/**
	 * @param string $name
	 * @param string $type
	 * @param array $options
	 * 
	 * @return static
	 */
	public function add($name, $type, array $options = [])
	{
		$this->children[$name] = [
			'type'		=>	$type,
			'options'	=>	$options
		];
		
		return $this;
	}
	
	/**
	 * @return FormInterface
	 */
	public function getForm()
	{
		$form = new Form($this->name, $this->resolvedType, $this->action, $this->method, $this->config,
            $this->factory, $this->handler, $this->dispatcher);
		foreach($this->children as $name => $_) {
		    try
            {
                $child = $this->resolveChild($name);
                $form->add($child);
            } catch(\Exception $e) {

            }
		}
		
		return $form;
	}

    /**
     * @param $name
     *
     * @return mixed
     * @throws \Exception
     */
	private function resolveChild($name)
	{
		if (!isset($this->children[$name]))
			throw new \Exception();
		
		/* @var array */
		$child = $this->children[$name];
		//resolve..
		unset($this->children[$name]);
		
		/* @var FormBuilderInterface */
		$builder = $this->create($name, $child['type'], $child['options']);

		return $builder->getForm();
	}
}