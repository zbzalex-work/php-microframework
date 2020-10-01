<?php

namespace Xand\Component\Form\Type;
use Xand\Component\Form\Type;

/**
 * Class TextType
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class TextType extends Type
{
    /**
     * @return string
     */
	public function getBlockName()
	{
		return "text";
	}
}