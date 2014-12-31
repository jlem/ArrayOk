<?php namespace Jlem\ArrayOk;

class Proxy
{
    public static function flip(array $input)
    {
        return new ArrayOk(array_flip($input));
    }

    public static function order($target, $sequence, $cut = true)
    {
        $sequence = static::normalizeSequence($sequence);
        $sequence = array_flip($sequence);

        if ($cut) {
            $target = array_intersect_key($target, $sequence);
        }

        return static::replace($sequence, $target);
    }

    public static function intersectKeys(array $these, array $andThese)
    {
        return new ArrayOk(call_user_func_array('array_intersect_key', func_get_args()));
    }

    public static function cut(array $these, array $andThese)
    {
        return static::intersectKeys($these, array_flip($andThese));
    }

    public static function replace(array $toBeReplaced, array $replaceWith)
    {
        return new ArrayOk(call_user_func_array('array_replace', func_get_args()));
    }

    public static function isAssociativeArray($array)
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

    public static function isAok($data)
    {
        return $data instanceof ArrayOk;
    }

    public static function json($data)
    {
        $data = new ArrayOk($data); // Wrap it as an ArrayOk object in case it's only a partial object
        return $data->toJson();
    }

    protected static function normalizeSequence($sequence)
    {
        return is_array($sequence) ? $sequence : static::commasToArray($sequence);
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
