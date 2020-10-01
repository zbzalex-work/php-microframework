<?php

namespace Xand\Component\Form;

/**
 * Class Type
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class Type implements TypeInterface
{
    /**
     * @param \Xand\Component\Form\FormConfig $config
     *
     * @return array|void
     */
	public function configure(FormConfig $config)
	{

	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * 
	 * @return mixed
	 */
	public function buildForm(FormBuilderInterface $builder)
	{

	}
	
	/**
	 * @param FormView $view
	 * @param FormInterface $form
	 * 
	 * 	@return mixed
	 */
	public function buildView(FormView $view, FormInterface $form)
	{
		$view->config = \array_merge($form->getConfig()->toArray(), [
		    "block_name" => $this->getBlockName()
        ]);
		$view->config['attributes']['name'] = $form->getName();
	}
	
	/**
	 * @return string
	 */
	public function getBlockName()
	{
		return "";
	}
}