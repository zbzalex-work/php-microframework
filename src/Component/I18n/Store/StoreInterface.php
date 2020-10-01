<?php

namespace Xand\Component\I18n\Store;

/**
 * Interface StoreInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface StoreInterface
{
    /**
     * @param string    $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @param string    $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string    $key
     * @param string    $translate
     */
    public function set($key, $translate);

    /**
     * @param string    $key
     */
    public function remove($key);
}