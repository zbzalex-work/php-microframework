<?php

namespace Xand\Component\Form;

/**
 * Interface FormBuilderInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface FormBuilderInterface
{
    /**
     * @param string $action
     *
     * @return mixed
     */
    public function setAction($action);

    /**
     * @param string $method
     *
     * @return mixed
     */
    public function setMethod($method);

    /**
     * @return \Xand\Component\Form\FormConfig
     */
    public function getConfig();

    /**
     * @return \Xand\Component\Form\FormInterface
     */
    public function getForm();

    /**
     * @param       $name
     * @param       $type
     * @param array $options
     *
     * @return mixed
     */
    public function add($name, $type, array $options = []);
}