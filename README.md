<h1 style="text-align: center">ryanwhowe/dot</h1>

<p style="text-align: center">
    <strong>A PHP library to access and set array values using dot notation or any other key separator.</strong>
</p>

<p style="text-align: center">
    <a href="https://github.com/ryanwhowe/dot"><img src="https://img.shields.io/badge/source-ryanwhowe/dot-blue.svg?style=flat-square" alt="Source Code"></a>
     <a href="https://php.net"><img src="https://img.shields.io/packagist/php-v/ryanwhowe/dot.svg?style=flat-square&colorB=%238892BF" alt="PHP Programming Language"></a>
    <a href="https://github.com/ryanwhowe/dot/blob/1.x/LICENSE"><img src="https://img.shields.io/packagist/l/ryanwhowe/dot.svg?style=flat-square&colorB=darkcyan" alt="Read License"></a>
    <a href="https://github.com/ryanwhowe/dot/actions/workflows/php.yml"><img src="https://img.shields.io/github/actions/workflow/status/ryanwhowe/dot/php.yml?branch=1.x&logo=github&style=flat-square" alt="Build Status"></a>
</p>

Q: There are quite a few 'dot' projects that exist on Packagist, what is different about this one?
>
> Every other 'dot' project requires you to create a copy of your data and instantiate a new class, this project
> uses light weight static methods to access and modify your existing arrays without the need to create a second
> copy of the data.

>
> The other advantage that this has over many other implementations is that you can select an alternative key
> separator than a '.' which is necessary if you have key values that contain '.' characters in them.

Q: Why add this to Packagist?
>
> This package has been used on several of my projects both personally and professionally and I am tired of copying
> the class from one project to another. If my teams and I get usage out of this project, I wanted to share it to
> allow anyone else who this could help use it as well.

## Installation

The preferred method of installation is via [Composer][]. Run the following command to install the package and add it as
a requirement to your project's `composer.json`:

```bash
composer require ryanwhowe/dot
```

## Usage

The Dot class contains 4 static methods to facilitate the safe access and setting of array data in php.

### `Dot::has()`

The `Dot::has()` checks to see if there is a value in the search array for the search key.

#### Description

```
Dot::has(array $searchArray, string $searchKey, string $delimiter = '.'): bool
```

#### Parameters

<dl>
<dt>searchArray</dt>
<dd>The array that will be searched for the provided key value</dd>

<dt>searchKey</dt>
<dd>The delimited key that will be searched for in the provided searchArray.  If the array does not have string 
keys number strings can be used instead to access the appropriate position in the array</dd>

<dt>delimiter</dt>
<dd>The key delimiter can be specified, this is needed when there are '.' values contained within the expected 
array keys already</dd>
</dl>

#### Return Values

The method returns `true` if found and `false` if not.

#### Examples

##### Example #1 simple key value lookup

```php
<?php
$array = ['test' => ['test1' => 'test1value']];

var_export(Dot::has($array, 'test.test1')); echo PHP_EOL;
var_export(Dot::has($array, 'test.test2')); echo PHP_EOL;
```

```shell
true
false
```

##### Example #2 mixed key lookup

```php
<?php
$array = ['test' => ['valueForKey0', 'valueForKey1']];

var_export(Dot::has($array, 'test.0')); echo PHP_EOL;
var_export(Dot::has($array, 'test~0', '~')); echo PHP_EOL;
var_export(Dot::has($array, 'test.5')); echo PHP_EOL;
```

```shell
true
true
false
```

### `Dot::get()`

The `Dot::get()` method is get getting data from an array provided that there is a key that exists in the search
location, if there is not, then return a default value instead. This method utilizes recursion to traverse the array.
Most installations of php have a recursion depth limit of 100, if you need to search further down than 100 levels this
likely is the wrong tool to utilize.

#### Description

```
Dot::get(array $searchArray, string $searchKey, mixed $default = null, string $delimiter = '.'): mixed
```

#### Parameters

<dl>
<dt>searchArray</dt>
<dd>The array that will be searched for the provided key value</dd>

<dt>searchKey</dt>
<dd>The delimited key that will be searched for in the provided searchArray.  If the array does not have string 
keys number strings can be used instead to access the appropriate position in the array</dd>

<dt>default</dt>
<dd>The default value to return if the searchKey is not found in the searchArray</dd>

<dt>delimiter</dt>
<dd>The key delimiter can be specified, this is needed when there are '.' values contained within the expected 
array keys already</dd>
</dl>

#### Return Values

Returns from the method are the mixed value stored in the array at the searched key position or the default value
provided.

#### Examples

##### Example #1 simple key value lookup

```php
<?php
$array = ['test' => ['test1' => 'test1value']];

echo Dot::get($array, 'test.test1', 'Nothing Here'), PHP_EOL;
echo Dot::get($array, 'test.test2', 'Nothing Here'), PHP_EOL;
```

```shell
test1value
Nothing Here
```

##### Example #2 mixed key lookup

```php
<?php
$array = ['test' => ['valueForKey0', 'valueForKey1']];

echo Dot::get($array, 'test.0', 'Nothing Here'), PHP_EOL;
echo Dot::get($array, 'test|0', 'Nothing Here', '|'), PHP_EOL;
echo Dot::get($array, 'test.4', 'Nothing Here'), PHP_EOL;
```

```shell
valueForKey0
valueForKey0
Nothing Here
```

### `Dot::set()`

The `Dot::set()` method will set the passed value inside the provided array at the location of the key provided.  
The set method will create the key structure needed to place the value in the array if it is not present already This
method utilizes recursion to traverse the array. Most installations of php have a recursion depth limit of 100, if you
need to search further down than 100 levels this likely is the wrong tool to utilize.

#### Description

```
Dot::set(array &$setArray, string $setKey, mixed $value, string $delimiter = '.'): void
```

#### Parameters

<dl>
<dt>setArray</dt>
<dd>The array that will the value will be placed inside</dd>

<dt>setKey</dt>
<dd>The delimited key that will be searched for in the provided searchArray.  If the array does not have string 
keys number strings can be used instead to access the appropriate position in the array</dd>

<dt>value</dt>
<dd>The default value to return if the searchKey is not found in the searchArray</dd>

<dt>delimiter</dt>
<dd>The key delimiter can be specified, this is needed when there are '.' values contained within the expected 
array keys already</dd>
</dl>

#### Return Values

There is no return for this method, the array is passed by reference and is updated with the inserted value.

#### Examples

##### Example #1 simple key value lookup

```php
<?php
$array = ['test' => []];

Dot::set($array, 'test.test1', 'test1value');
var_export($array); echo PHP_EOL;
Dot::set($array, 'test.test2', 'test2value');
var_export($array); echo PHP_EOL;
```

```shell
array (
  'test' => 
  array (
    'test1' => 'test1value',
  ),
)
array (
  'test' => 
  array (
    'test1' => 'test1value',
    'test2' => 'test2value',
  ),
)
```

##### Example #2 nested setting

```php
<?php
$array = ['test' => []];

Dot::set($array, 'test.test2.test21', 'test21value');
var_export($array); echo PHP_EOL;
Dot::set($array, 'test~test2~test22', 'test22value', '~');
var_export($array); echo PHP_EOL;
```

```shell
array (
  'test' => 
  array (
    'test2' => 
    array (
      'test21' => 'test21value',
    ),
  ),
)
array (
  'test' => 
  array (
    'test2' => 
    array (
      'test21' => 'test21value',
      'test22' => 'test22value',
    ),
  ),
)
```

### `Dot::append()`

The `Dot::append()` method will set the passed value as an array value inside the provided array at the location of the key provided. If the location already contains a value the values will be merged into a single array.  The 
append method will create the key structure needed to place the array value in the array if it is not present already. This
method utilizes recursion to traverse the array. Most installations of php have a recursion depth limit of 100, if you
need to search further down than 100 levels this likely is the wrong tool to utilize.

#### Description

```
Dot::append(array &$setArray, string $setKey, mixed $value, string $delimiter = '.'): void
```

#### Parameters

<dl>
<dt>setArray</dt>
<dd>The array that will the value will be placed inside</dd>

<dt>setKey</dt>
<dd>The delimited key that will be searched for in the provided searchArray.  If the array does not have string 
keys number strings can be used instead to access the appropriate position in the array</dd>

<dt>value</dt>
<dd>The value be set in the array.  If the key location is not set already in the array the full path to the key location will be created and the value will be added to the key location in an array.  If there is already a value in the key location the new value will be appended to the end of the array.  If the value in the key location is not an array the location will be converted to an array and the new value will be appended to the end of the new array.</dd>

<dt>delimiter</dt>
<dd>The key delimiter can be specified, this is needed when there are '.' values contained within the expected 
array keys already</dd>
</dl>

#### Return Values

There is no return for this method, the array is passed by reference and is updated with the inserted value.

#### Examples

##### Example #1 insert with an existing value

```php
<?php
$test = array (
    'a' => array (
        'b' => array (
            'c' => 'd'
            )
        )
    );

Dot::append($test, 'a.b.c', 'e');
var_export($test);
```

```shell
array (
  'a' => 
  array (
    'b' => 
    array (
      'c' => 
      array (
        0 => 'd',
        1 => 'e',
      ),
    ),
  ),
)
```

##### Example #2 setting the key and creating an initial array

```php
<?php
$test = array (
    'a' => array (
        'b' => array ()
        )
    );

Dot::append($test, 'a.b.c', 'd');

var_export($test);
```

```shell
array (
  'a' => 
  array (
    'b' => 
    array (
      'c' => 
      array (
        0 => 'd',
      ),
    ),
  ),
)
```

### `Dot::delete()`

The `Dot::delete()` method will unset the key location provided.  If the key location is not in the array there will be no effect on the passed array. This
method utilizes recursion to traverse the array. Most installations of php have a recursion depth limit of 100, if you
need to search further down than 100 levels this likely is the wrong tool to utilize.

#### Description

```
Dot::delete(array &$setArray, string $setKey, string $delimiter = '.'): void
```

#### Parameters

<dl>
<dt>setArray</dt>
<dd>The array that will the value will be placed inside</dd>

<dt>setKey</dt>
<dd>The delimited key that will be searched for in the provided searchArray.  If the array does not have string 
keys number strings can be used instead to access the appropriate position in the array</dd>

<dt>delimiter</dt>
<dd>The key delimiter can be specified, this is needed when there are '.' values contained within the expected 
array keys already</dd>
</dl>

#### Return Values

There is no return for this method, the array is passed by reference and is updated.

#### Examples

##### Example #1 simple key value unset

```php
<?php
$test = array (
    'a' => array (
        'b' => array (
            'c' => array (
                'd',
                'e',
                'f'
                )
            )
        )
    );

Dot::delete($test, 'a.b.c');
var_export($test);
```

```shell
array (
  'a' => 
  array (
    'b' => 
    array (
    ),
  ),
)
```

### `Dot::count()`

The `Dot::count()` method will set the passed value inside the provided array at the location of the key provided.  
The set method will create the key structure needed to place the value in the array if it is not present already This
method utilizes recursion to traverse the array. Most installations of php have a recursion depth limit of 100, if you
need to search further down than 100 levels this likely is the wrong tool to utilize.

#### Description

```
Dot::count(array &$setArray, string $setKey, string $delimiter = '.', int $return = Dot::ZERO_ON_NON_ARRAY): int
```

#### Parameters

<dl>
<dt>setArray</dt>
<dd>The array that will the value will be placed inside</dd>

<dt>setKey</dt>
<dd>The delimited key that will be searched for in the provided searchArray.  If the array does not have string 
keys number strings can be used instead to access the appropriate position in the array</dd>

<dt>delimiter</dt>
<dd>The key delimiter can be specified, this is needed when there are '.' values contained within the expected 
array keys already</dd>

<dt>return</dt>
<dd>By default the method will return 0 if the value at the key location either does not have a value set or if the 
value is not an array.  This can be changed using the Dot::NEGATIVE_ON_NON_ARRAY constant instead return a -1 if 
there is not a value set or the value is not an array at the key location.
</dd>
</dl>

#### Return Values

The method returns an `int` with the count of the array elements. If the value at the key location is not an array or
not set the method by default will return a 0, this can be changed to return a -1 by setting the `return`
parameter to `Dot::NEGATIVE_ON_NON_ARRAY`.

#### Examples

##### Example #1 simple array count

```php
<?php
$array = ['test' => [1,2,3,4,5], 'test1' => ['test2' => [1,2,3]]];

$result = Dot::count($array, 'test');
var_export($result); echo PHP_EOL;
$result = Dot::count($array, 'test1.test2');
var_export($result); echo PHP_EOL;
```

```shell
5
3
```

##### Example #2 no element found and non array elements

```php
<?php
$array = ['test' => 1, 'test1' => []];

/* A non array value */
$result = Dot::count($array, 'test');
var_export($result); echo PHP_EOL;
$result = Dot::count($array, 'test', Dot::DEFAULT_DELIMITER, Dot::NEGATIVE_ON_NON_ARRAY);
var_export($result); echo PHP_EOL;

/* A key that has no value */
$result = Dot::count($array, 'test1.test2');
var_export($result); echo PHP_EOL;
$result = Dot::count($array, 'test1.test2', Dot::DEFAULT_DELIMITER, Dot::NEGATIVE_ON_NON_ARRAY);
var_export($result); echo PHP_EOL;

/* An empty array */
$result = Dot::count($array, 'test1');
var_export($result); echo PHP_EOL;
$result = Dot::count($array, 'test1', Dot::DEFAULT_DELIMITER, Dot::NEGATIVE_ON_NON_ARRAY);
var_export($result); echo PHP_EOL;
```

```shell
0
-1
0
-1
0
0
```

### `Dot::flatten()`

The `Dot::flatten()` method will flatten a multidimensional array to a single dimensional array with the dotKeys =>
values as the returned new array. Each non-array value in the source array will have a cooresponding line in the output
array. This method utilizes recursion to traverse the array. Most installations of php have a recursion depth limit of
100, if you need to search further down than 100 levels this likely is the wrong tool to utilize.

#### Description

```
Dot::flatten(array $array, string $delimiter = '.', string $prepend = ''): array
```

#### Parameters

<dl>
<dt>array</dt>
<dd>The source data array</dd>

<dt>delimiter</dt>
<dd>The key delimiter can be specified, this is needed when there are '.' values contained within the expected 
array keys already, the "flattened" keys will be delimited by this value.</dd>

<dt>prepend</dt>
<dd>Primarily used in the method's recursion, this can be used to prepend a string to the generated keys</dd>

</dl>

#### Return Values

The method will return an array 1 dimension deep with `array<dotKeys, mixed>`
>
> ***INFO:*** The `Dot::set()` method can be used over the resulting rows of the flattened array to reconstruct the
> original input array
>

#### Examples

##### Example #1 simple key value lookup

```php
<?php
$array = [
    'test1' => 
        [
            'test2' => 'test12value',
            'test3' => ['test4' => 'test134value'],
            'test5' => ['test150value', 'test151value']
        ]
    ];

var_export(Dot::flatten($array));
```

```shell
array (
  'test1.test2' => 'test12value',
  'test1.test3.test4' => 'test134value',
  'test1.test5.0' => 'test150value',
  'test1.test5.1' => 'test151value',
)
```

[composer]: http://getcomposer.org/