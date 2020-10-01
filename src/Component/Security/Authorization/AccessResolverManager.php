<?php

namespace Xand\Component\Security\Authorization;

use Xand\Component\Security\Authorization\Voter\VoterInterface;
use Xand\Component\Security\Token\Storage\TokenStorageInterface;

class AccessResolverManager
{
    /**
     * @var VoterInterface[]
     */
    protected $voters;

    /**
     * AccessResolverManager constructor.
     *
     * @param VoterInterface[] $voters
     */
    public function __construct(array $voters)
    {
        $this->voters = $voters;
    }

    /**
     * @param TokenStorageInterface $token
     * @param array                 $attrs
     * @param null                  $subj
     *
     * @return bool
     */
    public function resolve(TokenStorageInterface $token, array $attrs = [], $subj = null)
    {
        foreach($this->voters as $voter) {
            $result = $voter->vote($token, $subj, $attrs);
            switch($result) {
                case VoterInterface::ACCESS_GRANTED:
                    {
                        return true;
                    }
                    break;
//                case VoterInterface::ACCESS_DENIED:
//                    {
//
//                    }
            }
        }

        return false;
    }
}