<?php

namespace Xand\Component\Validator;

/**
 * Interface ConstraintViolationInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ConstraintViolationInterface
{
    /**
     * @return string
     */
    public function getMessage();
}