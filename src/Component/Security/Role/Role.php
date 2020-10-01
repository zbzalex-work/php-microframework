<?php

namespace Xand\Component\Security\Role;

/**
 * @author alex
 */
class Role
{
    /**
     * @var string
     */
    protected $role;

    /**
     * Role constructor.
     *
     * @param string $role
     */
    public function __construct(
        $role
    )
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
}