<?php

namespace Xand\Component\Security\Authorization;
use Xand\Component\Security\Authentication\AuthenticationManagerInterface;
use Xand\Component\Security\Token\Storage\TokenStorageInterface;

/**
 * @author alex
 */
class AuthorizationChecker
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;

    /**
     * @var AccessResolverManager
     */
    protected $accessResolverManager;

    /**
     * AuthorizationChecker constructor.
     *
     * @param TokenStorageInterface          $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     * @param AccessResolverManager          $accessResolverManager
     */
    public function __construct(TokenStorageInterface $tokenStorage,
                                AuthenticationManagerInterface $authenticationManager,
                                AccessResolverManager $accessResolverManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->accessResolverManager = $accessResolverManager;
    }

    /**
     * @param array $attrs
     * @param null  $subj
     *
     * @return bool
     * @throws \Exception
     */
    public function isGranted(array $attrs = [], $subj = null)
    {
        if (null === ($token = $this->tokenStorage->getToken()))
            throw new \Exception();

        return $this->accessResolverManager->resolve($token, $attrs, $subj);
    }
}