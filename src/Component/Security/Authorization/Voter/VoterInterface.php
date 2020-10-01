<?php

namespace Xand\Component\Security\Authorization\Voter;
use Xand\Component\Security\Token\TokenInterface;

/**
 * @author alex
 */
interface VoterInterface
{
    /**
     * @const int
     */
    const ACCESS_GRANTED = 1;

    /**
     * @const int
     */
    const ACCESS_DENIED = 0;

    /**
     * @param TokenInterface $token
     * @param object         $obj
     * @param array          $attrs
     *
     * @return mixed
     */
    public function vote(TokenInterface $token, $obj, array $attrs = []);
}