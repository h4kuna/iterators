<?php declare(strict_types=1);

namespace h4kuna\Iterators\Tests;

use h4kuna\Iterators\TextIterator;
use Salamium\Testinium\File;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class TextIteratorTest extends \Tester\TestCase
{

	/**
	 * @var TextIterator
	 */
	protected $object;


	protected function setUp()
	{
		$text = "1Lorem;ipsum;dolor sit;Windows\r\n Lorem;ipsum;dolor sit;Solaris \n\r Lorem;ipsum;dolor sit;Linux\nLorem;ipsum;dolor sit;Mac \r   \n\nLorem;ipsum;dolor sit;amet";
		$this->object = new TextIterator($text);
	}


	public function testNoSetup(): void
	{
		$compare = $this->loadContent();
		Assert::same(File::load('noSetup.csv'), $compare);
	}


	public function testSkipEmpty(): void
	{
		$this->object->setFlags(TextIterator::SKIP_EMPTY_LINE);
		$compare = $this->loadContent();
		Assert::same(File::load('emptyLine.csv'), $compare);
	}


	public function testSkipEmptyTrim(): void
	{
		$this->object->setFlags(TextIterator::SKIP_EMPTY_LINE | TextIterator::TRIM_LINE);
		$compare = $this->loadContent();
		Assert::same(File::load('trimEmptyLine.csv'), $compare);
	}


	public function testCsvWithHead(): void
	{
		$this->object->setCsv(';');
		$compare = $this->loadContent();
		Assert::same(File::load('csvWithHead.csv'), $compare);
	}


	public function testCsv(): void
	{
		$this->object->setFlags(TextIterator::SKIP_FIRST_LINE);
		$this->object->setCsv(';');
		$compare = $this->loadContent();
		Assert::same(File::load('csv.csv'), $compare);
	}


	private function loadContent(): string
	{
		$compare = '';
		foreach ($this->object as $row) {
			if ($compare) {
				$compare .= "\n";
			}
			$compare .= is_array($row) ? serialize($row) : $row;
		}

		return $compare;
	}

}

(new TextIteratorTest)->run();
