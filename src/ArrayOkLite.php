<?php

namespace Jlem\ArrayOk;

class ArrayOkLite
{
    /**
     * @var array
     */
    public $items;

    /**
     * ArrayOkLite constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function toArray()
    {
        return $this->items;
    }

    /**
     * Returns the conctents of the entire array ok object, or the contents of a specific key
     *
     * @param mixed null|string|array $keys
     * @access public
     * @return mixed
     */

    public function get($keys = null)
    {
        return ($keys) ? $this->getRecursively($keys) : $this;
    }


    /**
     * Recurses through the nested object graph to get the value of the furthest key
     *
     * @param mixed string|array $keys
     * @access protected
     * @return mixed
     */

    public function getRecursively($keys)
    {
        $keys = $this->normalizeKeys($keys);
        $value = $this->items;

        foreach ($keys as $key) {
            $value = $this->getValue($value, $key);
        }

        return $value;
    }

    protected function getValue($value, $key)
    {
        if (!is_array($value)) {
           return $value;
        }

        return isset($value[$key]) ? $value[$key] : null;
    }

    /**
     * Converts a dot notation string to an array, or passes a given array through
     *
     * @param mixed string|array $keys
     * @access protected
     * @return array
     */

    protected function normalizeKeys($keys)
    {
        return is_array($keys) ? $keys : explode('.', $keys);
    }
}