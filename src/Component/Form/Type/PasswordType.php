<?php

namespace Xand\Component\Form\Type;
use Xand\Component\Form\Type;
use Xand\Component\Form\FormView;
use Xand\Component\Form\FormInterface;

/**
 * Class PasswordType
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class PasswordType extends Type
{
    /**
     * @return string
     */
	public function getBlockName()
	{
		return "password";
	}
}