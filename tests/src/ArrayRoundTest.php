<?php

namespace h4kuna;

class ArrayRoundTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ArrayRound
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new ArrayRound(new \ArrayIterator(self::getData()));
    }

    private static function getData()
    {
        return array(
            'name', 'surname', 'email'
        );
    }

    public function testRound()
    {
        foreach (array_merge(self::getData(), self::getData(), self::getData()) as $v) {
            $this->assertSame($v, $this->object->item());
        }
    }

    public function testEmpty()
    {
        $this->object = new ArrayRound(new \ArrayIterator(array()));
        foreach (array_merge(self::getData(), self::getData(), self::getData()) as $v) {
            $this->assertSame(NULL, $this->object->item());
        }
    }

}
