<?php

namespace Xand\Component\Form\Event;
use Xand\Component\EventDispatcher\Event;
use Xand\Component\Form\FormInterface;

/**
 * Class FormEvent
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormEvent extends Event
{
	/**
	 * @var FormInterface
	 */
	protected $form;
	
	/**
	 * @var array
	 */
	protected $data;

    /**
     * FormEvent constructor.
     *
     * @param \Xand\Component\Form\FormInterface $form
     * @param null                               $data
     */
	public function __construct(FormInterface $form, $data = null)
	{
		$this->form = $form;
		$this->data = $data;
	}
	
	/**
	 * @return FormInterface
	 */
	public function getForm()
	{
		return $this->form;
	}
	
	/**
	 * @param array $data
	 * 
	 * @return static
	 */
	public function setData(array $data)
	{
		$this->data = $data;
		
		return $this;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}
}