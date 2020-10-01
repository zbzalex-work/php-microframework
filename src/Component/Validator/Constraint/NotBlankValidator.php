<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;
use Xand\Component\Validator\ConstraintValidator;

/**
 * Class NotBlankValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class NotBlankValidator extends ConstraintValidator
{
    /**
     * @param string                               $value
     * @param \Xand\Component\Validator\Constraint $constraint
     *
     * @return void|\Xand\Component\Validator\ConstraintValidatorInterface
     */
    public function validate($value, Constraint $constraint)
    {
        $value = \trim($value);

        if (empty($value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}