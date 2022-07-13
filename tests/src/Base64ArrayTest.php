<?php

namespace h4kuna\Iterators;

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class Base64ArrayTest extends \Tester\TestCase
{

	private static function getHash()
	{
		return 'YToyOntpOjA7czo1OiJtaWxhbiI7aToxO3M6ODoibWF0ZWpjZWsiO30=';
	}

	private static function getArray()
	{
		return ['milan', 'matejcek'];
	}

	/**
	 * @covers h4kuna\Base64Array::hash
	 * @todo   Implement testHash().
	 */
	public function testFromArray(): void
	{
		$data = self::getArray();
		$base64 = new Base64Array($data);
		Assert::same('matejcek', $base64[1]);
		Assert::same(self::getHash(), $base64->hash());
	}

	public function testFromString(): void
	{
		$base64 = new Base64Array(self::getHash());
		Assert::same('matejcek', $base64[1]);
		Assert::same(self::getArray(), (array) $base64);
	}

}

(new Base64ArrayTest)->run();
