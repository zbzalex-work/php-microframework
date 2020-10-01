<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;

/**
 * Class Email
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Email extends Constraint
{
    /**
     * @var string
     */
    public $message;


    /**
     * NotBlank constructor.
     *
     * @param string $options
     */
    public function __construct(array $options = [])
    {
        $this->message = isset($options['message']) ? $options['message'] : null;
    }
}