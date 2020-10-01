<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;
use Xand\Component\Validator\ConstraintValidator;

/**
 * Class EmailValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class EmailValidator extends ConstraintValidator
{
    /**
     * @param string                               $value
     * @param \Xand\Component\Validator\Constraint $constraint
     *
     * @return void|\Xand\Component\Validator\ConstraintValidatorInterface
     */
    public function validate($value, Constraint $constraint)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->context->addViolation($constraint->message);
        }
    }
}