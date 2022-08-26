<?php declare(strict_types=1);

namespace h4kuna\Iterators\Tests;

use h4kuna\Iterators\FlattenArrayIterator;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class FlattenArrayIteratorTest extends TestCase
{

	/**
	 * @dataProvider sourceData
	 */
	public function testBasic(array $expected, array $input, string $delimiter): void
	{
		$iterator = new \RecursiveIteratorIterator(new FlattenArrayIterator($input, $delimiter));
		$output = [];
		foreach ($iterator as $key => $item) {
			$output[$key] = $item;
		}

		Assert::same($expected, $output);
	}


	public static function sourceData(): array
	{
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

		return [
			[
				'expected' => [],
				'input' => [],
				'delimiter' => '-',
			],

			[
				'expected' => [
					'address%street' => 'foo',
					'address%zip' => 29404,
					'address%c%p' => '5',
					'address%c%e' => 10.6,
					'main%0' => 'a',
					'main%1' => 'b',
					'main%2' => 'c',
					'email' => 'exampl@foo.com',
				],
				'input' => $input,
				'delimiter' => '%',
			],

			[
				'expected' => [
					'address-street' => 'foo',
					'address-zip' => 29404,
					'address-c-p' => '5',
					'address-c-e' => 10.6,
					'main-0' => 'a',
					'main-1' => 'b',
					'main-2' => 'c',
					'email' => 'exampl@foo.com',
				],
				'input' => $input,
				'delimiter' => '-',
			],

			[
				'expected' => [
					'' => 'bar',
				],
				'input' => [
					'' => 'foo',
					null => 'bar',
				],
				'delimiter' => '-',
			],
		];
	}

}

(new FlattenArrayIteratorTest())->run();
