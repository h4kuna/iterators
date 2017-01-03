h4kuna\iterators
================

[![Build Status](https://travis-ci.org/h4kuna/iterators.svg?branch=master)](https://travis-ci.org/h4kuna/iterators)

Best way to install h4kuna\iterators is using composer.
```
$ composer require h4kuna/iterators
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
$array = new Base64Array(array('milan', 'matejcek'));
echo $array; // YToyOntpOjA7czo1OiJtaWxhbiI7aToxO3M6ODoibWF0ZWpjZWsiO30=

$array = new Base64Array('YToyOntpOjA7czo1OiJtaWxhbiI7aToxO3M6ODoibWF0ZWpjZWsiO30=');
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

RangeIterator
-----------

Iterate in range defined by keys. Implemented Linked list.

```php
$range = new RangeIterator(['name' => 'milan', 'surname' => 'matejcek', 'lang' => 'php', 'gender' => 'male']);
foreach($range->from('lang') as $v) {
	echo $v;
}
// php
// male

$range->reset();
foreach($range->to('surname') as $v) {
	echo $v;
}
// milan
// matejcek


$range->reset();
foreach($range->between('surname', 'lang') as $v) {
	echo $v;
}
// matejcek
// php

```