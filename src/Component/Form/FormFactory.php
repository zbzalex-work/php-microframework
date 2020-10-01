<?php

namespace Xand\Component\Form;

/**
 * Class FormFactory
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormFactory implements FormFactoryInterface
{
	/**
	 * @var FormRegistry
	 */
	protected $registry;

    /**
     * FormFactory constructor.
     *
     * @param \Xand\Component\Form\FormRegistryInterface|null $registry
     */
	public function __construct(FormRegistryInterface $registry = null)
	{
		$this->registry = null === $registry ? new FormRegistry() : $registry;
	}

    /**
     * @param string $name
     * @param string $type
     * @param array  $options
     *
     * @return \Xand\Component\Form\FormBuilder|\Xand\Component\Form\FormBuilderInterface
     * @throws \ReflectionException
     */
	public function create($name, $type, array $options = [])
	{
	    $config = new FormConfig($options);

		$type = $this->registry->getType($type);
		$resolvedType = new ResolvedType($type);

		/* @var FormBuilderInterface */
		$builder = $resolvedType->createBuilder($name, $this, $config);
		$resolvedType->buildForm($builder);
		
		return $builder;
	}
}