<?php

namespace h4kuna\Iterators;

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class ArrayRoundTest extends \Tester\TestCase
{

	/**
	 * @var ArrayRound
	 */
	private $arrayRound;


	protected function setUp(): void
	{
		$this->arrayRound = new ArrayRound(new \ArrayIterator(self::getItems()));
	}


	/**
	 * @return array<string>
	 */
	private static function getItems(): array
	{
		return [
			'name',
			'surname',
			'email',
		];
	}


	public function testRound(): void
	{
		$this->arrayRound = new ArrayRound(self::getItems());
		foreach (array_merge(self::getItems(), self::getItems(), self::getItems()) as $v) {
			Assert::same($v, $this->arrayRound->item());
		}
	}


	public function testEmpty(): void
	{
		$this->arrayRound = new ArrayRound(new \ArrayIterator([]));
		foreach (array_merge(self::getItems(), self::getItems(), self::getItems()) as $v) {
			Assert::same(null, $this->arrayRound->item());
		}
	}

}

(new ArrayRoundTest)->run();
