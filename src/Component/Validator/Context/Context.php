<?php

namespace Xand\Component\Validator\Context;
use Xand\Component\Validator\Constraint;
use Xand\Component\Validator\ConstraintViolation;
use Xand\Component\Validator\ConstraintViolationMap;
use Xand\Component\Validator\ValidatorInterface;

/**
 * Class Context
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Context implements ContextInterface
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Constraint
     */
    protected $constraint;

    /**
     * @var ConstraintViolationMap
     */
    protected $violations;

    /**
     * Context constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->violations = new ConstraintViolationMap();
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return Constraint
     */
    public function getConstraint()
    {
        return $this->constraint;
    }

    /**
     * @param Constraint $constraint
     *
     * @return static
     */
    public function setConstraint(Constraint $constraint)
    {
        $this->constraint = $constraint;

        return $this;
    }

    /**
     * @param string    $message
     * @param array     $params
     *
     * @return static
     */
    public function addViolation($message, array $params = [])
    {
        $this->violations->add(new ConstraintViolation($message, $params));

        return $this;
    }

    /**
     * @return ConstraintViolationMap
     */
    public function getViolations()
    {
        return $this->violations;
    }
}