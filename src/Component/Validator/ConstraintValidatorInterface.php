<?php

namespace Xand\Component\Validator;
use Xand\Component\Validator\Context\Context;

/**
 * Interface ConstraintValidatorInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ConstraintValidatorInterface
{
    /**
     * @param Context $context
     *
     * @return static
     */
    public function setContext(Context $context);

    /**
     * @param string        $value
     * @param Constraint    $constraint
     *
     * @return static
     */
    public function validate($value, Constraint $constraint);
}