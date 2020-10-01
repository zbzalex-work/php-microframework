<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;

/**
 * Class NotBlank
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class NotBlank extends Constraint
{
    /**
     * @var string
     */
    public $message;


    /**
     * NotBlank constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->message = isset($options['message']) ? $options['message'] : null;
    }
}