<?php


namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;

/**
 * Class CreditCardExpiry
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class CreditCardExpiry extends Constraint
{
    /**
     * @var string
     */
    public $message;


    /**
     * CreditCardExpiry constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->message = isset($options['message']) ? $options['message'] : null;
    }
}