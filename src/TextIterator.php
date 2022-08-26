<?php declare(strict_types=1);

namespace h4kuna\Iterators;

/**
 * Iterate via line
 * @phpstan-type LINE string|array<string>
 * @extends \ArrayIterator<int, LINE>
 */
class TextIterator extends \ArrayIterator
{

	public const SKIP_EMPTY_LINE = 1048576; // 2^20
	public const CSV_MODE = 2097152; // 2^21
	public const SKIP_FIRST_LINE = 4194304; // 2^22
	public const TRIM_LINE = 8388608; // 2^23

	private string $_current = '';

	private int $flags = 0;

	/** @var array{delimiter: string, enclosure: string, escape: string} */
	private array $csv = [
		'delimiter' => ',',
		'enclosure' => '"',
		'escape' => '\\',
	];


	public function __construct(string $text)
	{
		parent::__construct(self::text2Array($text));
	}


	/**
	 * Active csv parser.
	 * @return self
	 */
	public function setCsv(string $delimiter = ',', string $enclosure = '"', string $escape = '\\')
	{
		$this->setFlags($this->getFlags() | self::SKIP_EMPTY_LINE | self::CSV_MODE | self::TRIM_LINE);
		if ($delimiter !== null) {
			$this->csv = [
				'delimiter' => $delimiter,
				'enclosure' => $enclosure,
				'escape' => $escape,
			];
		}

		return $this;
	}


	/**
	 * @return array<string>
	 */
	private static function text2Array(string $text): array
	{
		$text = preg_replace("/\r\n|\n\r|\r/", "\n", $text);
		assert($text !== null);

		return is_array($text) ? $text : explode("\n", rtrim($text));
	}


	/**
	 * Change API behavior *****************************************************
	 * *************************************************************************
	 */

	/**
	 * @param int $flags
	 */
	public function setFlags($flags)
	{
		parent::setFlags($flags);
		$this->flags = $flags;
	}


	public function getFlags(): int
	{
		return parent::getFlags() | $this->flags;
	}


	/** @return LINE */
	public function current()
	{
		$content = $this->_current;
		if ($this->getFlags() & self::CSV_MODE) {
			$result = str_getcsv($content, $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
			assert(is_array($result));

			return $result;
		}

		return $content;
	}


	public function rewind(): void
	{
		parent::rewind();
		if (self::SKIP_FIRST_LINE & $this->getFlags()) {
			$this->next();
		}
	}


	public function valid(): bool
	{
		do {
			if (parent::valid() === false) {
				return false;
			}
			$current = parent::current();
			assert(is_string($current));
			$this->_current = $current;
			if ($this->getFlags() & self::TRIM_LINE) {
				$this->_current = trim($this->_current);
			}
		} while ($this->getFlags() & self::SKIP_EMPTY_LINE && !$this->_current && $this->next() === null);

		return true;
	}

}
