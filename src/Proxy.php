<?php namespace Jlem\ArrayOk;

class Proxy
{
    public static function flip(array $input)
    {
        return new ArrayOk(array_flip($input));
    }

    public static function order($target, $sequence, $cut = true)
    {
        $target = static::normalizeArray($target);
        $sequence = static::normalizeSequence($sequence);

        if ($cut) {
            $target->cut($sequence->items);
        }

        return $sequence->flip()->replace($target->items);
    }

    public static function intersect(array $these, array $andThese)
    {
        return call_user_func_array('array_intersect', func_get_args());
    }

    public static function intersectKeys(array $these, array $andThese)
    {
        return new ArrayOk(call_user_func_array('array_intersect_key', func_get_args()));
    }

    public static function cut(array $these, array $andThese)
    {
        return static::intersectKeys($these, static::flip($andThese)->items);
    }

    public static function replace(array $toBeReplaced, array $replaceWith)
    {
        return new ArrayOk(call_user_func_array('array_replace', func_get_args()));
    }

    public static function isAok($data)
    {
        return $data instanceof ArrayOk;
    }

    public static function isArray($data)
    {
        return is_array($data);
    }

    protected static function normalizeSequence($sequence)
    {
        if (static::isAok($sequence)) {
            return $sequence;
        }

        if (static::isArray($sequence)) {
            return new ArrayOk($sequence);
        }

        return new ArrayOk(static::commasToArray($sequence));
    }

    protected static function commasToArray($string)
    {
        return explode(',', $string);
    }

    protected static function dotsToArray($string)
    {
        return explode('.', $string);
    }

    protected static function normalizeArray($array)
    {
        return static::isAok($array) ? $array : new ArrayOk($array);
    }
}
