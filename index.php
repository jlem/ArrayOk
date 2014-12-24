<?php
require 'vendor/autoload.php';

use Jlem\ArrayOk\Proxy;
use Jlem\ArrayOk\ArrayOk;

$config = array(
	'one' => 'won',
	'two' => 'too',
	'three' => 'tree'
);

$context = array(
	'vader' => 'two', 
	'yoda' => 'three',
	'luke' => 'five'
);

$replacement = array(
	'vader' => 'vvv', 
	'yoda' => 'yyy',
	'luke' => 'lll'
);


$newOrder = 'luke,yoda';
$intersect = array('luke', 'yoda');

$context2 = ArrayOk::order($context, $newOrder, false);
$context = new ArrayOk($context);
$context->order($newOrder, false);

//$results = Proxy::order($context, $newOrder);

var_dump($context2);
var_dump($context);
