<?php

namespace Xand\Component\Validator;
use Xand\Component\Validator\Context\ContextFactory;

/**
 * Class ValidatorBuilder
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ValidatorBuilder
{
    /**
     * @var string
     */
    protected $contextFactoryClass;

    /**
     * @var string
     */
    protected $constraintValidatorFactoryClass;

    /**
     * @param string    $class
     *
     * @return static
     */
    public function setContextFactoryClass($class)
    {
        $this->contextFactoryClass = $class;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContextFactoryClass()
    {
        return $this->contextFactoryClass;
    }

    /**
     * @param string $class
     *
     * @return static
     */
    public function setConstraintValidatorFactoryClass($class)
    {
        $this->constraintValidatorFactoryClass = $class;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getConstraintValidatorFactoryClass()
    {
        return $this->constraintValidatorFactoryClass;
    }

    /**
     * @return RecursiveContextualValidator
     */
    public function getValidator()
    {
        $contextFactoryClass = $this->contextFactoryClass;
        $constraintValidatorFactoryClass = $this->constraintValidatorFactoryClass;
        $contextFactory = null === $contextFactoryClass ? new ContextFactory() : new $contextFactoryClass();
        $constraintValidatorFactory = null === $constraintValidatorFactoryClass ? new ConstraintValidatorFactory() : new $constraintValidatorFactoryClass();

        return new RecursiveContextualValidator($contextFactory, $constraintValidatorFactory);
    }
}