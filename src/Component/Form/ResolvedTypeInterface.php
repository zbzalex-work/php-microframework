<?php

namespace Xand\Component\Form;

/**
 * Interface ResolvedTypeInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ResolvedTypeInterface
{
    /**
     * @param \Xand\Component\Form\FormBuilderInterface $builder
     *
     * @return mixed
     */
	public function buildForm(FormBuilderInterface $builder);

    /**
     * @param \Xand\Component\Form\FormView      $view
     * @param \Xand\Component\Form\FormInterface $form
     *
     * @return mixed
     */
	public function buildView(FormView $view, FormInterface $form);
}