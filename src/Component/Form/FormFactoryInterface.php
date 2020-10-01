<?php

namespace Xand\Component\Form;

/**
 * Interface FormFactoryInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface FormFactoryInterface
{
	/**
	 * @param string $name
	 * @param string $type
	 * @param array $options
	 * 
	 * @return FormBuilderInterface
	 */
	public function create($name, $type, array $options = []);
}