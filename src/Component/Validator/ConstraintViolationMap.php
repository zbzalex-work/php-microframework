<?php

namespace Xand\Component\Validator;

/**
 * Class ConstraintViolationMap
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ConstraintViolationMap
{
    /**
     * @var ConstraintViolationInterface[]
     */
    protected $violations;

    /**
     * ConstraintViolationMap constructor.
     */
    public function __construct()
    {
        $this->violations = [];
    }

    /**
     * @param ConstraintViolationInterface $violation
     *
     * @return static
     */
    public function add(ConstraintViolationInterface $violation)
    {
        $this->violations[] = $violation;

        return $this;
    }

    /**
     * @return static
     */
    public function clear()
    {
        $this->violations = [];

        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->violations);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->violations);
    }
}