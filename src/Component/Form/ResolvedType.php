<?php

namespace Xand\Component\Form;

/**
 * Class ResolvedType
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ResolvedType implements ResolvedTypeInterface
{
	/**
	 * @var TypeInterface
	 */
	protected $type;

    /**
     * ResolvedType constructor.
     *
     * @param \Xand\Component\Form\TypeInterface $type
     */
	public function __construct(TypeInterface $type)
	{
		$this->type = $type;
	}

    /**
     * @param                                           $name
     * @param \Xand\Component\Form\FormFactoryInterface $factory
     * @param \Xand\Component\Form\FormConfig           $config
     *
     * @return \Xand\Component\Form\FormBuilder
     */
	public function createBuilder($name, FormFactoryInterface $factory, FormConfig $config)
	{
		/* @var array */
		$this->type->configure($config);

		return new FormBuilder($name, $this, $config, $factory);
	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * 
	 * @return static
	 */
	public function buildForm(FormBuilderInterface $builder)
	{
		$this->type->buildForm($builder);
		
		return $this;
	}
	
	/**
	 * @param FormView $view
	 * @param FormInterface $form
	 * 
	 * @return static
	 */
	public function buildView(FormView $view, FormInterface $form)
	{
		$this->type->buildView($view, $form);
		
		return $this;
	}
}