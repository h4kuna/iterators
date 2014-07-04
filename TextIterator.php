<?php

namespace h4kuna;

use ArrayIterator;

/**
 * Iterate via line
 * 
 * @author Milan Matějček <milan.matejcek@gmail.com>
 */
class TextIterator extends ArrayIterator {

    const TRIM_LINE = 1073741824;
    const SKIP_EMPTY_LINE = 2147483648;
    const CSV_MODE = 4294967296;

    /** @var string */
    private $_current;

    /** @var int */
    private $flags;

    /** @var array */
    private $csv = array(
        'delimiter' => ',',
        'enclosure' => '"',
        'escape' => '\\'
    );

    public function __construct($text) {
        parent::__construct($this->text2Array($text));
    }

    /**
     * Active csv parser
     * 
     * @param NULL|string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @return self
     */
    public function setCsv($delimiter = NULL, $enclosure = '"', $escape = '\\') {
        $this->setFlags($this->getFlags() | self::SKIP_EMPTY_LINE | self::CSV_MODE | self::TRIM_LINE);
        if ($delimiter !== NULL) {
            $this->csv = array(
                'delimiter' => $delimiter,
                'enclosure' => $enclosure,
                'escape' => $escape
            );
        }
        return $this;
    }

    private function text2Array($text) {
        return is_array($text) ? $text : explode("\n", rtrim(preg_replace("/\n?\r/", "\n", $text)));
    }

    /**
     * Use in while cycle.
     * 
     * @return bool
     */
    public function nextWhile() {
        return $this->next() && $this->valid();
    }

    /**
     * Change API behavior *****************************************************
     * *************************************************************************
     */
    public function setFlags($flags) {
        parent::setFlags($flags);
        $this->flags = $flags;
    }

    public function getFlags() {
        return parent::getFlags() | $this->flags;
    }

    /** @return string */
    public function current() {
        $content = $this->_current;
        if ($this->getFlags() & self::CSV_MODE) {
            return str_getcsv($content, $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);
        }
        return $content;
    }

    /** @return bool */
    public function valid() {
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
     * For while cycle return TRUE
     * 
     * @return bool 
     */
    public function next() {
        parent::next();
        return TRUE;
    }

}
