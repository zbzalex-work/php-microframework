<?php

namespace Xand\Component\Security\Authorization\Voter;
use Xand\Component\Security\Token\TokenInterface;

/**
 * @author alex
 */
class Voter implements VoterInterface
{
    /**
     * @param TokenInterface $token
     * @param object         $obj
     * @param array          $attrs
     *
     * @return mixed|void
     */
    public function vote(TokenInterface $token, $obj, array $attrs = [])
    {
        // TODO: Implement vote() method.
    }
}