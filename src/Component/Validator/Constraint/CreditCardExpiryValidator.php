<?php


namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;
use Xand\Component\Validator\ConstraintValidator;

/**
 * Class CreditCardExpiryValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class CreditCardExpiryValidator extends ConstraintValidator
{
    /**
     * @param string                               $value
     * @param \Xand\Component\Validator\Constraint $constraint
     *
     * @return void|\Xand\Component\Validator\ConstraintValidatorInterface
     */
    public function validate($value, Constraint $constraint)
    {
        if (!\preg_match("/^(?<month>\d{1,2})\s*\/\s*(?<year>\d{2})$/", $value, $matches)
            || 1  > $matches['month']
            || 12 < $matches['month']
            || \date("y") == $matches['year'] && \date('n') > $matches['month']
            || \date("y") > $matches['year']) {
            $this->context->addViolation("Invalid date expiry format");
        }
    }
}