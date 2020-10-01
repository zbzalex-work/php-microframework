<?php

namespace Xand\Component\Validator;

/**
 * Class ValidatorBuilderFactory
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ValidatorBuilderFactory
{
    /**
     * @return ValidatorBuilder
     */
    public static function createBuilder()
    {
        return new ValidatorBuilder();
    }
}