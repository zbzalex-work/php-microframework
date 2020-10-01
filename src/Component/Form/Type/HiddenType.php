<?php

namespace Xand\Component\Form\Type;
use Xand\Component\Form\FormInterface;
use Xand\Component\Form\FormView;
use Xand\Component\Form\Type;

/**
 * Class HiddenType
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class HiddenType extends Type
{
    /**
     * @param \Xand\Component\Form\FormView      $view
     * @param \Xand\Component\Form\FormInterface $form
     *
     * @return mixed|void
     */
	public function buildView(FormView $view, FormInterface $form)
	{
		parent::buildView($view, $form);
		$view->config = $form->getConfig();
		$view->config['attributes']['type']	= "hidden";
	}

    /**
     * @return string
     */
	public function getBlockName()
	{
		return "hidden";
	}
}