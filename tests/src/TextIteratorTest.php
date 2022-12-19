<?php declare(strict_types=1);

namespace h4kuna\Iterators\Tests;

use h4kuna\Iterators\TextIterator;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class TextIteratorTest extends \Tester\TestCase
{

	protected TextIterator $object;


	protected function setUp()
	{
		$text = "1Lorem;ipsum;dolor sit;Windows\r\n Lorem;ipsum;dolor sit;Solaris \n\r Lorem;ipsum;dolor sit;Linux\nLorem;ipsum;dolor sit;Mac \r   \n\nLorem;ipsum;dolor sit;amet";
		$this->object = new TextIterator($text);
	}


	public function testNoSetup(): void
	{
		$compare = $this->loadContent();
		Assert::same(loadResult('noSetup'), $compare);
	}


	public function testSkipEmpty(): void
	{
		$this->object->setFlags(TextIterator::SKIP_EMPTY_LINE);
		$compare = $this->loadContent();
		Assert::same(loadResult('emptyLine'), $compare);
	}


	public function testSkipEmptyTrim(): void
	{
		$this->object->setFlags(TextIterator::SKIP_EMPTY_LINE | TextIterator::TRIM_LINE);
		$compare = $this->loadContent();
		Assert::same(loadResult('trimEmptyLine'), $compare);
	}


	public function testCsvWithHead(): void
	{
		$this->object->setCsv(';');
		$compare = $this->loadContent();
		Assert::same(loadResult('csvWithHead'), $compare);
	}


	public function testCsv(): void
	{
		$this->object->setFlags(TextIterator::SKIP_FIRST_LINE);
		$this->object->setCsv(';');
		$compare = $this->loadContent();
		Assert::same(loadResult('csv'), $compare);
	}


	private function loadContent(): string
	{
		$compare = [];
		foreach ($this->object as $row) {
			$compare[] = is_array($row) ? serialize($row) : $row;
		}

		return implode("\n", $compare);
	}

}

(new TextIteratorTest)->run();
