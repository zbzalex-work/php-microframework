<?php

namespace Xand\Component\Validator\Context;
use Xand\Component\Validator\ValidatorInterface;

/**
 * Class ContextFactory
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ContextFactory
{
    /**
     * @return ContextInterface
     */
    public function createContext(ValidatorInterface $validator)
    {
        return new Context($validator);
    }
}