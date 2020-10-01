<?php

namespace Xand\Component\Validator;
use Xand\Component\Validator\Context\Context;

/**
 * Class ConstraintValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class ConstraintValidator implements ConstraintValidatorInterface
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param \Xand\Component\Validator\Context\Context $context
     *
     * @return $this|\Xand\Component\Validator\ConstraintValidatorInterface
     */
    public function setContext(Context $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @param string                               $value
     * @param \Xand\Component\Validator\Constraint $constraint
     *
     * @return void|\Xand\Component\Validator\ConstraintValidatorInterface
     */
    public function validate($value, Constraint $constraint) {}
}