<?php

namespace Xand\Component\Validator;
use Xand\Component\Validator\Context\ContextFactory;
use Xand\Component\Validator\Context\ContextInterface;

/**
 * Class ContextualValidator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ContextualValidator implements ValidatorInterface
{
    /**
     * @var ContextInterface
     */
    protected $context;

    /**
     * @var ConstraintValidatorFactory
     */
    protected $constraintValidatorFactory;

    /**
     * ContextualValidator constructor.
     *
     * @param ContextInterface           $context
     * @param ConstraintValidatorFactory $constraintValidatorFactory
     */
    public function __construct(ContextInterface $context, ConstraintValidatorFactory $constraintValidatorFactory)
    {
        $this->context = $context;
        $this->constraintValidatorFactory = $constraintValidatorFactory;
    }

    /**
     * @param string $value
     * @param array  $constraints
     *
     * @return $this
     */
    public function validate($value, array $constraints = [])
    {
        foreach($constraints as $constraint) {
            try
            {
                /** @var ConstraintValidatorInterface */
                $constraintValidator = $this->constraintValidatorFactory->getConstraintValidator($constraint);
                $constraintValidator->setContext($this->context)->validate($value, $constraint);
            } catch(\Exception $e) {}
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getViolations()
    {
        return $this->context->getViolations();
    }
}