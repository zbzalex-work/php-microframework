<?php

namespace Xand\Component\Validator;

/**
 * Class Constraint
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Constraint implements ConstraintInterface
{
    /**
     * @return string
     */
    public function getValidatorClass()
    {
        return \get_class($this) . "Validator";
    }
}