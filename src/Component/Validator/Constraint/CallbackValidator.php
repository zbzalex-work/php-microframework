<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;
use Xand\Component\Validator\ConstraintValidator;

/**
 * Class CallbackValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class CallbackValidator extends ConstraintValidator
{
    /**
     * @param string                               $value
     * @param \Xand\Component\Validator\Constraint $constraint
     *
     * @return void|\Xand\Component\Validator\ConstraintValidatorInterface
     */
    public function validate($value, Constraint $constraint)
    {
        \call_user_func_array($constraint->callback, [
            $this->context,
            $value
        ]);
    }
}