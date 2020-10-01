<?php

namespace Xand\Component\Validator\Constraint;
use Xand\Component\Validator\Constraint;

/**
 * Class Callback
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Callback extends Constraint
{
    /**
     * @var \Closure
     */
    public $callback;

    /**
     * Callback constructor.
     *
     * @param \Closure $callback
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }
}