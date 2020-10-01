<?php

namespace Xand\Component\Form;

/**
 * Interface TypeInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface TypeInterface
{
    /**
     * @param \Xand\Component\Form\FormConfig $config
     *
     * @return mixed
     */
	public function configure(FormConfig $config);
	
	/**
	 * @param FormBuilderInterface $builder
	 */
	public function buildForm(FormBuilderInterface $builder);
	
	/**
	 * @param FormView $view
	 * @param FormInterface $form
	 */
	public function buildView(FormView $view, FormInterface $form);
	
	/**
	 * @return string
	 */
	public function getBlockName();
}