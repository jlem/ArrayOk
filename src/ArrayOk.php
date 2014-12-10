<?php namespace Jlem\ArrayOk

class ArrayOk implements ArrayAccess
{
    use ArrayAccessTrait;

    public $items;

    public function __construct(array $items)
    {
        $this->constructRecursively($items);
    }

    public function get($keys = null)
    {
        return ($keys) ? $this->getRecursively($keys) : $this->items;
    }

    public function sortAZ($flag = SORT_REGULAR)
    {
        
    }

    public function sortOrder(array $input)
    {
        return $this->items = array_replace(array_flip($input), $this->items);
    }

    public function prepend($value, $key = null)
    {
        $key ? $this->unshiftKey($key, $value) : $this->unshift($value);
    }

    public function append($value, $key = null) 
    {
        $key ? $this->pushKey($key, $value) : $this->push($value);
    }

    public function remove($key)
    {
        unset($this->items[$key]);
    }

    public function exists($key)
    {
        return isset($this->items[$key]);
    }

    public function isAok($object) 
    {
        return $object instanceof $this; 
    }

    private function set($value) 
    {
        return is_array($value) ? new ArrayOk($value) : $value;
    }

    private function push($value)
    {
        $this->items[] = $this->set($value);
    }

    private function pushKey($key, $value)
    {
        $this->items[$key] = $this->set($value);
    }

    private function unshift($value)
    {
        array_unshift($this->items, $this->set($value));
    }

    private function unshiftKey($key, $value)
    {
        $newItem = array($key => $this->set($value));
        $this->items = array_merge($newItem, $this->items);
    }

    private function getSingle($key) 
    {
        return $this->exists($key) ? $this->items[$key] : null;
    }

    private function getRecursively($keys)
    {
        return array_reduce($this->normalizeKeys($keys), function($carry, $item) {
            return ($this->isAok($carry)) ? $carry->getSingle($item) : null;
        }, $this);
    }

    private function normalizeKeys($keys)
    {
        return is_array($keys) ?: explode('.', $keys);
    }

    private function constructRecursively($data)
    {
        foreach($data as $key => $item) {
            $this->append($item, $key);
        }
    }

    public function toArray()
    {
        $items = [];
        foreach($this->get() as $key => $item) {
            $items[$key] = $this->isAok($item) ? $item->toArray() : $item;
        }

        return $items;
    }
}
