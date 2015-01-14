h4kuna\iterators
================

[![Build Status](https://travis-ci.org/h4kuna/iterators.svg?branch=master)](https://travis-ci.org/h4kuna/iterators)

Best way to install h4kuna\iterators is using composer.
```
$ composer require h4kuna/iterators:~1.1
```

TextIterator
------------

Read the text line by line.
```php
$incomingString = "  foo

bar
joe";

$textIterator = new TextIterator($incomingString);
$textIterator->setFlags($textIterator::SKIP_EMPTY_LINE | $textIterator::TRIM_LINE);
foreach($textIterator as $line) {
    echo $line;
}
/*
 * output will be trimed
foo
bar
joe
*/
```

Base64Array
-----------

Create hash based on the base_64 from array and back.

```php
$array = Base64Array(array('milan', 'matejcek'));
echo $array; // YToyOntpOjA7czo1OiJtaWxhbiI7aToxO3M6ODoibWF0ZWpjZWsiO30=

$array = Base64Array('YToyOntpOjA7czo1OiJtaWxhbiI7aToxO3M6ODoibWF0ZWpjZWsiO30=');
var_dump((array) $array); // array('milan', 'matejcek')
```

ArrayRound
----------

Non-ended array.

```php
$array = new ArrayRound(array('foo', 'bar', 'joe'));
$array->item(); // foo
$array->item(); // bar
$array->item(); // joe
$array->item(); // foo
// and go next
```
