<?php

namespace Xand\Component\Form\Type;
use Xand\Component\Form\Type;
use Xand\Component\Form\FormBuilderInterface;
use Xand\Component\Form\FormView;
use Xand\Component\Form\FormInterface;

/**
 * Class FormType
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormType extends Type
{
	/**
	 * @param FormBuilderInterface $builder
	 */
	public function buildForm(FormBuilderInterface $builder)
	{

	}

	/**
	 * @param FormView $view
	 * @param FormInterface $form
	 */
	public function buildView(FormView $view, FormInterface $form)
	{
		parent::buildView($view, $form);

		$view->config = \array_merge($form->getConfig()->toArray(), [
		    "block_name" => $this->getBlockName(),
        ]);
		$view->config['attributes']['name'] = $form->getName();
		
		$view->config['attributes']['action'] = $form->getAction();
		$view->config['attributes']['method'] = $form->getMethod();
	}
	
	/**
	 * @return string
	 */
	public function getBlockName()
	{
		return 'form';
	}
}