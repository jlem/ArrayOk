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

$context2 = ArrayOk::replace($context, $replacement);
$context = new ArrayOk($context);
$context->replace($replacement);

//$results = Proxy::order($context, $newOrder);

var_dump($context);
var_dump($context2);