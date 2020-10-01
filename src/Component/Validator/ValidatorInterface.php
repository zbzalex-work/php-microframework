<?php

namespace Xand\Component\Validator;

/**
 * Interface ValidatorInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * @param string                    $value
     * @param ConstraintValidator[]     $constraints
     */
    public function validate($value, array $constraints = []);
}