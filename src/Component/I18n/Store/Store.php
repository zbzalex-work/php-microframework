<?php

namespace Xand\Component\I18n\Store;

/**
 * Class Store
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Store implements StoreInterface
{
    /**
     * @var array<string, string>
     */
    protected $data;

    /**
     * Store constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function import(array $data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @return array
     */
    public function export()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->has($key) ? $this->data[ $key ] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $translate)
    {
        $this->data[ $key ] = $translate;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return static
     */
    public function remove($key)
    {
        if (isset($this->data[ $key ]))
            unset($this->data[ $key ]);

        return $this;
    }
}