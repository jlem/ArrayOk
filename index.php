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

$newOrder = 'luke,yoda';

$context2 = ArrayOk::order($context, $newOrder);
$context = new ArrayOk($context);
$context->order($newOrder);

//$results = Proxy::order($context, $newOrder);

var_dump($context);
var_dump($context2);