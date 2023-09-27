# Moved to [h4kuna/data-type](https://github.com/h4kuna/data-type/tree/main/src/Iterators)

h4kuna\iterators
================

[![Downloads this Month](https://img.shields.io/packagist/dm/h4kuna/iterators.svg)](https://packagist.org/packages/h4kuna/iterators)
[![Latest Stable Version](https://poser.pugx.org/h4kuna/iterators/v/stable?format=flat)](https://packagist.org/packages/h4kuna/iterators)
[![Total Downloads](https://poser.pugx.org/h4kuna/iterators/downloads?format=flat)](https://packagist.org/packages/h4kuna/iterators)
[![License](https://poser.pugx.org/h4kuna/iterators/license?format=flat)](https://packagist.org/packages/h4kuna/iterators)

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

FlattenArrayIterator
-----------

Make one level array from multidimensional with to use delimiter for join keys.

```php
use h4kuna\Iterators\FlattenArrayRecursiveIterator;

$input = [
    'address' => [
        'street' => 'foo',
        'zip' => 29404,
        'c' => [
            'p' => '5',
            'e' => 10.6,
        ],
    ],
    'main' => ['a', 'b', 'c'],
    'email' => 'exampl@foo.com',
];

$iterator = new FlattenArrayRecursiveIterator($input, '%');
$output = [];
foreach ($iterator as $key => $item) {
    $output[$key] = $item;
}

// output is
// [
//    'address%street' => 'foo',
//    'address%zip' => 29404,
//    'address%c%p' => '5',
//    'address%c%e' => 10.6,
//    'main%0' => 'a',
//    'main%1' => 'b',
//    'main%2' => 'c',
//    'email' => 'exampl@foo.com',
// ]
```

PeriodDayFactory
-----------

Iterate between dates by days. A time is reset to midnight.

```php
use h4kuna\Iterators\PeriodDayFactory;
$endDate = new \DateTime('1996-04-09 08:00:00');
$period = PeriodDayFactory::createExFromInTo(new \DateTime('1989-02-01 07:00:00'), $endDate);

foreach ($period as $date) {
    // first date is 1989-02-02
    // last date is 1996-04-09
}

```
