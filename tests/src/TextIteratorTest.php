<?php

namespace h4kuna;

class TextIteratorTest extends \PHPUnit_Framework_TestCase
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

    private static function getFileContent($name, $data = NULL)
    {
        $file = __DIR__ . '/../data/' . $name . '.csv';
        if ($data !== NULL) {
            file_put_contents($file, $data);
        }
        $data = file_get_contents($file);
        return $data;
    }

    public function testNoSetup()
    {
        $compare = $this->loadContent();
        $this->assertSame(self::getFileContent('noSetup'), $compare);
    }

    public function testSkipEmpty()
    {
        $this->object->setFlags(TextIterator::SKIP_EMPTY_LINE);
        $compare = $this->loadContent();
        $this->assertSame(self::getFileContent('emptyLine'), $compare);
    }

    public function testSkipEmptyTrim()
    {
        $this->object->setFlags(TextIterator::SKIP_EMPTY_LINE | TextIterator::TRIM_LINE);
        $compare = $this->loadContent();
        $this->assertSame(self::getFileContent('trimEmptyLine'), $compare);
    }

    public function testCsvWithHead()
    {
        $this->object->setCsv(';');
        $compare = $this->loadContent();
        $this->assertSame(self::getFileContent('csvWithHead'), $compare);
    }

    public function testCsv()
    {
        $this->object->setFlags(TextIterator::SKIP_FIRST_LINE)->setCsv(';');
        $compare = $this->loadContent();
        $this->assertSame(self::getFileContent('csv'), $compare);
    }

    private function loadContent()
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
