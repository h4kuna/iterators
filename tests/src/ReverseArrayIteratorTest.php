<?php

namespace h4kuna\Iterators;

require __DIR__ . '/../bootstrap.php';

use Tester\Assert;

final class ReverseArrayIteratorTest extends \Tester\TestCase
{

	public function testBasic()
	{
		$original = ['foo', 'bar', 'baz'];
		$new = [];
		foreach (new ReverseArrayIterator($original) as $k => $v) {
			$new[$k] = $v;
		}

		Assert::same($new, array_reverse($original, TRUE));
	}


}

(new ReverseArrayIteratorTest)->run();
