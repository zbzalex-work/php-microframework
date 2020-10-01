<?php

namespace Xand\Component\Validator;

/**
 * Interface ConstraintValidatorFactoryInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ConstraintValidatorFactoryInterface
{
    /**
     * @param Constraint $constraint
     *
     * @return ConstraintValidator
     */
    public function getConstraintValidator(Constraint $constraint);
}