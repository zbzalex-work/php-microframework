<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;
use Xand\Component\Validator\ConstraintValidator;

/**
 * Class LengthValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class LengthValidator extends ConstraintValidator
{
    /**
     * @param string                               $value
     * @param \Xand\Component\Validator\Constraint $constraint
     *
     * @return void|\Xand\Component\Validator\ConstraintValidatorInterface
     */
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/.{' . $constraint->min . ',}/ui', $value))
            $this->context->addViolation($constraint->minMessage, [
                'limit' => $constraint->min
            ]);

        if (!preg_match('/.{' . $constraint->max . '}/ui', $value) && 0 != $this->max)
            $this->context->addViolation($constraint->maxMessage, [
                'limit' => $constraint->max
            ]);
    }
}