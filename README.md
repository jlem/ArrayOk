ArrayOK is a simple wrapper for nested, multi-dimensional arrays that makes it easy to do deep searching and index lookups.

ArrayOk is *not* intended to be used as a Collection wrapper

# API:

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
$aok['one']                                 // array access equivalent
$aok->get('one.two.three')                  // returns 'four', using dot notation
$aok['one.two.three']                       // equivalent to the above
$aok->get('one')->get('two')->get('three')  // do some chaining
$aok['one']['two']['three']                 // equivalent to the above
$aok->get('one')['two']->get('three')       // its A-Ok to get weird with it
$aok->get('blah')                           // returns null (anything it doesn't find is always null)
$aok->toArray()                             // returns full object graph as a plain array


// Mutating

$aok->append('value')                       // adds a numerically indexed value to the end. (if value is array, it becomes an ArrayOk object)
$aok[] = 'value'                            // array access equivalent
$aok->append('value', 'optional_key')       // adds a value with the optionally provided key to the end. (if value is array, it becomes an ArrayOk object)
$aok['key'] = $value                        // array access equivalent
$aok->prepend('value')                      // adds a numerically indexed value at the beginning. (if value is array, it becomes an ArrayOk object)
$aok->prepend('value', 'optional_key')      // adds a value with the optionally provided key to the beginning (if value is array, it becomes ArrayOk object)
$aok->remove('Foo')                         // removes the 'Foo' element from the top level array (TODO: recursive / seek option)


// Sorting

$aok->orderBy(['Foo', 'Hello', 'one'])      // explicitly changes the order of the array to match the given input array


// Misc

$aok->exists($key)                          // checks whether the given key is set in the top level array (TODO: recursive seeking / checking)
```
