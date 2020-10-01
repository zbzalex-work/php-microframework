<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;

/**
 * Class Length
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Length extends Constraint
{
    public $min;
    public $max;
    public $minMessage;
    public $maxMessage;

    /**
     * NotBlank constructor.
     *
     * @param array     $options
     */
    public function __construct(array $options = [])
    {
        $this->min = isset($options['min']) ? $options['min'] : 1;
        $this->max = isset($options['max']) ? $options['max'] : 0;
        $this->minMessage = isset($options['minMessage']) ? $options['minMessage'] : 1;
        $this->maxMessage = isset($options['maxMessage']) ? $options['maxMessage'] : 1;
    }
}