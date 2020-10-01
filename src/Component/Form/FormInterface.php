<?php

namespace Xand\Component\Form;
use Xand\Component\Foundation\ServerRequest;

/**
 * Interface FormInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface FormInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getAction();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return \Xand\Component\Form\FormInterface[]
     */
    public function children();

    /**
     * @return \Xand\Component\Form\FormConfig
     */
    public function getConfig();

	/**
	 * @param array|string $submittedData
	 */
	public function submit($submittedData);

    /**
     * @param \Xand\Component\Foundation\ServerRequest $request
     *
     * @return mixed
     */
	public function handleRequest(ServerRequest $request);

    /**
     * @return bool
     */
    public function isSubmitted();

    /**
     * @return bool
     */
    public function isValid();

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function addError($message);

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getData();

    /**
     * @param \Xand\Component\Form\FormView|null $parent
     *
     * @return mixed
     */
    public function createView(FormView $parent = null);
}