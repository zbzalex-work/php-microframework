<?php

namespace Xand\Component\Form\Type;
use Xand\Component\Form\FormView;
use Xand\Component\Form\FormInterface;
use Xand\Component\Form\Type;

/**
 * Class SubmitType
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class SubmitType extends Type
{
    /**
     * @param \Xand\Component\Form\FormView      $view
     * @param \Xand\Component\Form\FormInterface $form
     */
	public function buildView(FormView $view, FormInterface $form)
	{
		parent::buildView($view, $form);
		$view->config['attributes']['type']	= "submit";
	}

    /**
     * @return string
     */
	public function getBlockName()
	{
		return "submit";
	}
}