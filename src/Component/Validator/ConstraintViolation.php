<?php

namespace Xand\Component\Validator;

/**
 * Class ConstraintViolation
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ConstraintViolation implements ConstraintViolationInterface
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $params;

    /**
     * ConstraintViolation constructor.
     *
     * @param string    $message
     * @param array     $params
     */
    public function __construct($message, array $params = [])
    {
        $this->message = $message;
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }
}