<?php

namespace Xand\Component\Validator;

/**
 * Class ConstraintValidatorFactory
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ConstraintValidatorFactory implements ConstraintValidatorFactoryInterface
{
    /**
     * @var array
     */
    protected $constrainValidators;

    /**
     * ConstraintValidatorFactory constructor.
     */
    public function __construct()
    {
        $this->constrainValidators = [];
    }

    /**
     * @param Constraint $constraint
     *
     * @return ConstraintValidator
     */
    public function getConstraintValidator(Constraint $constraint)
    {
        /** @var string */
        $class = $constraint->getValidatorClass();

        if (!isset($this->constrainValidators[ $class ]))
                   $this->constrainValidators[ $class ] = new $class();

        return $this->constrainValidators[ $class ];
    }
}