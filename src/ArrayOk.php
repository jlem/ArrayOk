<?php namespace Jlem\ArrayOk;

class ArrayOk implements \ArrayAccess
{
    use ArrayAccessTrait;

    public $items;

    public function __construct(array $items = array())
    {
        $this->constructRecursively($items);
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
        return ($keys) ? $this->getRecursively($keys) : $this->items;
    }
    


    public function reverse($returnAsObject = false)
    {
        $items = $this->toArray();
        $items = array_reverse($items);

        if ($returnAsObject) {
            $items = new ArrayOk($items);
        }

        return $items;
    }


    /**
     * TODO 
     *
     * @param mixed $flag
     * @access public
     * @return void
    */

    public function sortAZ($flag = SORT_REGULAR)
    {
        
    }


    /**
     * Allows you to explicitly set the order of the array using another array whose values match the keys of the current object's keys 
     *
     * @param mixed array|string $input
     * @access public
     * @return array
    */

    public function orderBy($input, $flipInput = true)
    {
        $input = $this->normalizeKeys($input);

        if ($flipInput) {
            $input = array_flip($input);
        }

        return $this->items = new ArrayOk(array_replace($input, $this->items));
    }


    public function orderByAndGetIntersection($input, $flipInput = true)
    {
        $input = $this->normalizeKeys($input);

        if ($flipInput) {
            $input = array_flip($input);
        }

        $this->orderBy($input, false); // already flipped or false by definition

        return new ArrayOk($this->intersectKeys($input));
    }


    public function intersectKeys(array $input)
    {
        return array_intersect_key($this->items, $input);
    }

    public function intersect(array $input)
    {
        return array_intersect($this->items, $input);
    }


    /**
     * Prepends a new value to the beginning of the object 
     *
     * @param mixed $value
     * @param mixed null|string $key
     * @access public
     * @return void
    */

    public function prepend($value, $key = null)
    {
        $key ? $this->unshiftKey($key, $value) : $this->unshift($value);
    }


    /**
     * Appends a new value to the end of the object
     *
     * @param mixed $value
     * @param mixed null|string $key
     * @access public
     * @return void
    */

    public function append($value, $key = null) 
    {
        $key ? $this->pushKey($key, $value) : $this->push($value);
    }


    /**
     * Removes a single element from the object 
     *
     * @param string $key
     * @access public
     * @return void
    */

    public function remove($key)
    {
        unset($this->items[$key]);
    }


    /**
     * Checks to see if the objet contains the given key 
     *
     * @param string $key
     * @access public
     * @return bool
    */

    public function exists($key)
    {
        return isset($this->items[$key]);
    }


    /**
     * Checks to see if the object is empty
     *
     * @return  bool
     * @todo  recrusive seek
     */
    
    public function isEmpty($key = null)
    {
        if ($key) {
            return empty($this->items[$key]);
        }

        return empty($this->items);
    }


    /**
     * Checks to see if the given value/objet is also an ArrayOk object 
     *
     * @param mixed $object
     * @access public
     * @return bool
    */

    public function isAok($object) 
    {
        return $object instanceof $this; 
    }

    public function itemIsAok($item)
    {
        $object = $this->get($item);
        return $this->isAok($object);
    }


    /**
     * Converts the entire nested object graph into a plain array 
     *
     * @access public
     * @return array
    */

    public function toArray()
    {
        $items = [];
        $results = $this->get();
        
        if (!$results) {
            return array();
        }

        foreach($results as $key => $item) {
            $items[$key] = $this->isAok($item) ? $item->toArray() : $item;
        }

        return (array)$items;
    }


    /**
     * Sets the given value as either a primitive, or as a nested ArrayOk object if the given value is an array 
     *
     * @param mixed $value
     * @access protected
     * @return mixed
    */

    protected function set($value) 
    {
        return is_array($value) ? new ArrayOk($value) : $value;
    }


    /**
     * Pushes a keyless item onto the end of the object
     *
     * @param mixed $value
     * @access protected
     * @return void
    */

    protected function push($value)
    {
        $this->items[] = $this->set($value);
    }


    /**
     * Pushes a keyed item onto the end of the object 
     *
     * @param string $key
     * @param mixed $value
     * @access protected
     * @return void
    */

    protected function pushKey($key, $value)
    {
        $this->items[$key] = $this->set($value);
    }


    /**
     * Pushes a keyless item onto the beginning of the object 
     *
     * @param mixed $value
     * @access protected
     * @return void
    */

    protected function unshift($value)
    {
        array_unshift($this->items, $this->set($value));
    }


    /**
     * Pushes a keyed item onto the beginning of the object 
     *
     * @param string $key
     * @param mixed $value
     * @access protected
     * @return void
    */

    protected function unshiftKey($key, $value)
    {
        $newItem = array($key => $this->set($value));
        $this->items = array_merge($newItem, $this->items);
    }


    /**
     * Returns a single, first level item from the object, if it exists 
     *
     * @param string $key
     * @access protected
     * @return mixed
    */

    protected function getSingle($key) 
    {
        return $this->exists($key) ? $this->items[$key] : null;
    }


    /**
     * Recurses through the nested object graph to get the value of the furthest key 
     *
     * @param mixed string|array $keys
     * @access protected
     * @return mixed
    */

    protected function getRecursively($keys)
    {
        return array_reduce($this->normalizeKeys($keys), function($carry, $item) {
            return ($this->isAok($carry)) ? $carry->getSingle($item) : null;
        }, $this);
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


    /**
     * Recurses through a given array to create a nested set of ArrayOk objects
     *
     * @param array $data
     * @access protected
     * @return void
    */

    protected function constructRecursively($data)
    {
        foreach($data as $key => $item) {
            $this->append($item, $key);
        }
    }
}
