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

$test = new ArrayOk($initial);

$what = $test->get();

var_dump($what);

$thing = new ArrayOk($what);

var_dump($thing);

