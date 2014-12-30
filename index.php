<?php
require 'vendor/autoload.php';

use Jlem\ArrayOk\Proxy;
use Jlem\ArrayOk\ArrayOk;

$initial = [
    'slapp' => [
        'sith' => ['vader', 'sidious'],
        'jedi' => ['luke'],
        'special' => [
            'hi' => 'there'
        ],
        'asdfasdf' => 'dkdkdkd'
    ],
    'wat' => 'k?'
];

$replacement = [
    'slapp' => [
        'sith' => ['maul'],
        'special' => 'llll',
        'asdfasdf' => ['lolol'],
        'overrid' => 's'
    ],
    'hurr' => [
        'durr' => ['one', 'two', 'three']
    ]
];

$initial2 = new ArrayOk($initial);
$replacement2 = new ArrayOk($replacement);


function is_assoc($array) {
  return (bool)count(array_filter(array_keys($array), 'is_string'));
}

function recurse($array, $array1) {
    foreach ($array1 as $key => $value)
    {
        if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
            $array[$key] = array();
        }

        if (is_array($value)) {
            if (is_assoc($value)) {
                $value = recurse($array[$key], $value);
            }
        }
        $array[$key] = $value;
    }
    return $array;
}

function array_replace_recursive_alternative($array, $array1)
{

    // handle the arguments, merge one by one
    $args = func_get_args();

    $array = $args[0];

    for ($i = 1; $i < count($args); $i++) {
    $array = recurse($array, $args[$i]);
    }
    return $array;
}

/*$default = array_replace_recursive($initial, $replacement);
$alt = array_replace_recursive_alternative($initial, $replacement);
$initial2->replaceRecursive($replacement2);
echo 'DEFAULT';
var_dump($default);

echo 'ALTERNATIVE';
var_dump($alt);

echo 'ARRAYOK ALTERNATIVE';
var_dump($initial2->toArray());
var_dump($initial2->toArray() === $initial);
var_dump($replacement2->toArray() === $replacement);*/

$initial2->replaceRecursive($replacement2, true);
var_dump($initial2->toArray());
//var_dump(array_replace_recursive($initial2->toArray(), $replacement2->toArray()));
