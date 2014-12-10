Hi

API:

```php

// Given

$config = [
    'one' => [
        'two' => [
            'three' => 'four'
        ]
    ],
    'Hello' => 'World!',
    'Foo' => 'Bar'
];


// Create the new object

$aok = new Jlem\ArrayOk\ArrayOk($config);       // Builds a nested object graph of ArrayOk objects for each child array in $config


// Getting values

$aok->get()                                 // returns the full array & object graph
$aok->get('one')                            // returns an ArrayOk object since 'one' was an array
$aok->get('one.two.three')                  // returns 'four', using dot notation
$aok->get('one')->get('two')->get('three')  // Equivalent to the above since they are nested ArrayOk objects
$aok['one.two.three']                       // returns 'four', using array access dot notation
$aok['one']['two']['three']                 // Equivalent to the above
$aok->get('one')['two']->get('three')       // Go ahead, get weird with it
$aok->get('blah')                           // returns null (anything it doesn't find is null)
$aok->toArray()                             // returns full object graph as a plain array
```
