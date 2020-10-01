<?php

namespace Xand\Component\Form\Validator\Constraint;
use Xand\Component\Form\FormInterface;
use Xand\Component\Validator\Constraint;
use Xand\Component\Validator\ConstraintValidator;

/**
 * Class FormValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormValidator extends ConstraintValidator
{
    /**
     * @param \Xand\Component\Form\FormInterface   $form
     * @param \Xand\Component\Validator\Constraint $constraint
     *
     * @return void|\Xand\Component\Validator\ConstraintValidator
     */
    public function validate($form, Constraint $constraint)
    {
        if ($form->isSubmitted()) {
            /** @var array $data */
            $data = $form->getData();

            foreach($form->children() as $name => $child) {
                /** @var \Xand\Component\Form\FormConfig */
                $config = $child->getConfig();
                if (isset($config['constraints'])) {
                    $this->context->getValidator()->inContext($this->context)
                        ->validate((isset($data[ $name ]) ? $data[ $name ] : null), $config['constraints']);
                }
            }

            foreach($this->context->getViolations()->getIterator() as $violation) {
                $form->addError(\preg_replace_callback('/\:(\w+)/', function($matches) use($violation) {
                    /** @var array */
                    $params = $violation->getParams();
                    return isset($params[ $matches[1] ]) ? $params[ $matches[1] ] : "";
                }, $violation->getMessage()));
            }
        }
    }
}