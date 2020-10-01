<?php

namespace Xand\Component\DependencyInjection;

/**
 * Interface ContainerInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ContainerInterface extends \ArrayAccess
{
    /**
     * @const int
     */
    const INVALID_BEHAVIOR_NULL = 0;

    /**
     * @const int
     */
    const INVALID_BEHAVIOR_EXCEPTION = 1;

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id);
	
    /**
     * @param string $id
     * @param string $value
	 * 
	 * @return mixed
     */
    public function set($id, $value);

    /**
     * @param string $id
	 * 
	 * @return mixed
     */
    public function get($id);

    /**
     * @param string $id
	 * 
	 * @return void
     */
    public function remove($id);

    /**
     * @param \Closure $callable
     *
     * @return mixed
     */
    public function singleton(\Closure $callable);
}