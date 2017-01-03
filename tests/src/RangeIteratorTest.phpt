<?php

namespace h4kuna\Iterators;

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class RangeIteratorTest extends \Tester\TestCase
{

	public function testEmpty()
	{
		$iterator = new RangeIterator([]);
		Assert::same(0, $iterator->count());
		foreach ($iterator as $key) {
			throw new \RuntimeException();
		}
	}

	public function testFrom()
	{
		$iterator = $this->createRangeIterator();
		$iterator->from('d');
		$out = [];
		$condition = 0;
		foreach ($iterator as $k => $v) {
			$out[$k] = $v;
			if ($iterator->isLast()) {
				$condition |= 1;
				Assert::same('e', $k);
			}
		}
		Assert::same(1, $condition, 'Any condition is bad.');
		Assert::same(['d' => 4, 'e' => 5], $out);
	}

	public function testTo()
	{
		$iterator = $this->createRangeIterator();
		$iterator->to('b');
		$out = [];
		$condition = 0;
		foreach ($iterator as $k => $v) {
			$out[$k] = $v;
			if ($iterator->isFirst()) {
				$condition |= 1;
				Assert::same('a', $k);
			}
		}
		Assert::same(1, $condition, 'Any condition is bad.');
		Assert::same(['a' => 1, 'b' => 2], $out);
	}

	public function testBetween()
	{
		$iterator = $this->createRangeIterator();
		$iterator->between('b', 'd');
		$out = [];
		$condition = 0;
		foreach ($iterator as $k => $v) {
			$out[$k] = $v;
			if ($iterator->isFirst()) {
				$condition |= 1;
				Assert::same('b', $k);
			}
			if ($iterator->isLast()) {
				$condition |= 2;
				Assert::same('d', $k);
			}
		}
		Assert::same(3, $condition, 'Any condition is bad.');
		Assert::same(['b' => 2, 'c' => 3, 'd' => 4], $out);
	}

	public function testPrev()
	{
		$iterator = $this->createRangeIterator();
		$iterator->from('c')->rewind();
		$iterator->prev()->prev();

		Assert::same(1, $iterator->current());
		Assert::same('a', $iterator->key());
	}

	public function testReturnValueIterator()
	{
		$iterator = $this->createRangeIterator();
		Assert::same($iterator, $iterator->rewind());
		Assert::same($iterator, $iterator->next());
		Assert::same($iterator, $iterator->prev());
		Assert::same($iterator, $iterator->between('a', 'b'));
		Assert::same($iterator, $iterator->from('a'));
		Assert::same($iterator, $iterator->from('b'));
		Assert::same($iterator, $iterator->reset());
	}

	/** @return RangeIterator */
	private function createRangeIterator()
	{
		return new RangeIterator([
			'a' => 1,
			'b' => 2,
			'c' => 3,
			'd' => 4,
			'e' => 5
		]);
	}

}

(new RangeIteratorTest)->run();
