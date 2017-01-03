<?php

namespace h4kuna\Iterators;

/**
 * Iterate via line
 * @author Milan Matějček <milan.matejcek@gmail.com>
 */
class TextIterator extends \ArrayIterator
{

	const SKIP_EMPTY_LINE = 1048576; // 2^20
	const CSV_MODE = 2097152; // 2^21
	const SKIP_FIRST_LINE = 4194304; // 2^22
	const TRIM_LINE = 8388608; /* 2^23 */

	/** @var string */
	private $_current;

	/** @var int */
	private $flags;

	/** @var array */
	private $csv = [
		'delimiter' => ',',
		'enclosure' => '"',
		'escape' => '\\'
	];

	public function __construct($text)
	{
		parent::__construct($this->text2Array($text));
	}

	/**
	 * Active csv parser.
	 * @param NULL|string $delimiter
	 * @param string $enclosure
	 * @param string $escape
	 * @return self
	 */
	public function setCsv($delimiter = NULL, $enclosure = '"', $escape = '\\')
	{
		$this->setFlags($this->getFlags() | self::SKIP_EMPTY_LINE | self::CSV_MODE | self::TRIM_LINE);
		if ($delimiter !== NULL) {
			$this->csv = [
				'delimiter' => $delimiter,
				'enclosure' => $enclosure,
				'escape' => $escape
			];
		}
		return $this;
	}

	private function text2Array($text)
	{
		return is_array($text) ? $text : explode("\n", rtrim(preg_replace("/\r\n|\n\r|\r/", "\n", $text)));
	}

	/**
	 * Change API behavior *****************************************************
	 * *************************************************************************
	 */

	/**
	 *
	 * @param int $flags
	 * @return self
	 */
	public function setFlags($flags)
	{
		parent::setFlags($flags);
		$this->flags = $flags;
		return $this;
	}

	public function getFlags()
	{
		return parent::getFlags() | $this->flags;
	}

	/** @return string */
	public function current()
	{
		$content = $this->_current;
		if ($this->getFlags() & self::CSV_MODE) {
			return str_getcsv($content, $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
		}
		return $content;
	}

	public function rewind()
	{
		parent::rewind();
		if (self::SKIP_FIRST_LINE & $this->getFlags()) {
			$this->next();
		}
	}

	/** @return bool */
	public function valid()
	{
		do {
			$valid = parent::valid();
			$this->_current = parent::current();
			if ($this->getFlags() & self::TRIM_LINE) {
				$this->_current = trim($this->_current);
			}
		} while ($valid && $this->getFlags() & self::SKIP_EMPTY_LINE && !$this->_current && $this->next());
		return $valid;
	}

	/**
	 * Used for empty lines.
	 * @return TRUE
	 */
	public function next()
	{
		parent::next();
		return TRUE;
	}

}
