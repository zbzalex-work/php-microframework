<?php

namespace Xand\Component\Validator\Context;
use Xand\Component\Validator\ValidatorInterface;

/**
 * Interface ContextInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ContextInterface
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator();
}