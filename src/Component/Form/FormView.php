<?php

namespace Xand\Component\Form;

/**
 * Class FormView
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormView
{
	/**
	 * @var FormView
	 */
	public $parent;
	
	/**
	 * @var FormView[]
	 */
	public $children = [];
	
	/**
	 * @var array
	 */
	public $config = [];
}