<?php

namespace Xand\Component\Validator;

/**
 * Interface ConstraintInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ConstraintInterface
{
    /**
     * @return string
     */
    public function getValidatorClass();
}