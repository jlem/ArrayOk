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


// Wrap it

$aok = new Jlem\ArrayOk\ArrayOk($config);       // Builds a nested object graph of ArrayOk objects for each child array in $config


// Getting single values. All of these are valid.

$aok->get('blah')                           // returns null (anything it doesn't find is always null)
$aok->get('one')                            // returns an ArrayOk object since 'one' was an array
$aok->get(['one'])                          // ... or use an array argument with object access
$aok['one']                                 // ... or use array access
$aok[['one']]                               // ... or use array argument with array access



// Getting nested values. All of these are valid.

$aok->get()                                 // returns the full array & object graph
$aok->toArray()                             // returns full object graph as a plain array
$aok->get('one.two.three')                  // returns 'four' using dot notation with object access
$aok->get(['one', 'two', 'three'])          // ... or use an array argument with object access
$aok['one.two.three']                       // ... or use dot notation argument with array access
$aok[['one', 'two', 'three']]               // ... or use array argument with array access
$aok['one']['two']['three']                 // ... or use chained array access
$aok->get('one')->get('two')->get('three')  // ... or use chained object access
$aok->get('one')['two']->get('three')       // ... or mix it up
$aok['one.two']->get(['three'])             // ... mixing is A-Ok ;) just be careful about non-object returns (TODO: "safe mode" that returns null objects for safe chaining)



// Mutating

$aok->append('value')                       // adds a numerically indexed value to the end. (if value is array, it becomes an ArrayOk object)
$aok[] = 'value'                            // array access equivalent
$aok->append('value', 'optional_key')       // adds a value with the optionally provided key to the end. (if value is array, it becomes an ArrayOk object)
$aok['key'] = $value                        // array access equivalent
$aok->prepend('value')                      // adds a numerically indexed value at the beginning. (if value is array, it becomes an ArrayOk object)
$aok->prepend('value', 'optional_key')      // adds a value with the optionally provided key to the beginning (if value is array, it becomes ArrayOk object)
$aok->remove('Foo')                         // removes the 'Foo' element from the top level array (TODO: recursive / seek option)


// Sorting

$aok->sortOrder(['Foo', 'Hello', 'one'])      // explicitly changes the order of the array to match the given input array


// Misc

$aok->exists($key)                          // checks whether the given key is set in the top level array (TODO: recursive seeking / checking)
```
