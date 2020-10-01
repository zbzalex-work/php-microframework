<?php

namespace Xand\Component\Form;

/**
 * Interface FormRendererInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface FormRendererInterface
{
    /**
     * @param                               $blockName
     * @param \Xand\Component\Form\FormView $view
     * @param array                         $params
     *
     * @return mixed
     */
	public function renderBlock($blockName, FormView $view, array $params = []);
}