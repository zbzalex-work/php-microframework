<?php

namespace Xand\Component\Validator;
use Xand\Component\Validator\Context\ContextFactory;
use Xand\Component\Validator\Context\ContextInterface;

/**
 * Class RecursiveContextualValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class RecursiveContextualValidator implements ValidatorInterface
{
    /**
     * @var ContextFactory
     */
    protected $contextFactory;

    /**
     * @var ConstraintValidatorFactory
     */
    protected $constraintValidatorFactory;

    /**
     * RecursiveContextualValidator constructor.
     *
     * @param ContextFactory             $contextFactory
     * @param ConstraintValidatorFactory $constraintValidatorFactory
     */
    public function __construct(ContextFactory $contextFactory,
                                ConstraintValidatorFactory $constraintValidatorFactory)
    {
        $this->contextFactory = $contextFactory;
        $this->constraintValidatorFactory = $constraintValidatorFactory;
    }

    /**
     * @param \Xand\Component\Validator\Context\ContextInterface $context
     *
     * @return \Xand\Component\Validator\ContextualValidator
     */
    public function inContext(ContextInterface $context)
    {
        return (new ContextualValidator($context, $this->constraintValidatorFactory));
    }

    /**
     * @param string $value
     * @param array  $constraints
     *
     * @return mixed
     */
    public function validate($value, array $constraints = [])
    {
        /** @var ContextInterface $context */
        $context = $this->contextFactory->createContext($this);

        return $this->inContext($context)->validate($value, $constraints)->getViolations();
    }
}