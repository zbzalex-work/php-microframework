<?php

namespace Xand\Component\Validator;

/**
 * Class Validator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Validator
{
    /**
     * @var \Xand\Component\Validator\Context\ContextInterface
     */
    protected $context;

    /**
     * @var \Xand\Component\Validator\ValidatorBuilderFactory
     */
    protected $constraintValidatorFactory;
}