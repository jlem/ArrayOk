<?php namespace Jlem\ArrayOk;

trait ArrayAccessTrait
{
    public function offsetExists($offset) {
        return $this->exists($offset);
    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value) {
        $this->append($value, $offset);
    }

    public function offsetUnset($offset) {
        $this->remove($offset);
    }

}
