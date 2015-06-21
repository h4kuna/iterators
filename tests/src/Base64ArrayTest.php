<?php

namespace h4kuna\Iterators;

class Base64ArrayTest extends \PHPUnit_Framework_TestCase
{

    private static function getHash()
    {
        return 'YToyOntpOjA7czo1OiJtaWxhbiI7aToxO3M6ODoibWF0ZWpjZWsiO30=';
    }

    private static function getArray()
    {
        return array('milan', 'matejcek');
    }

    /**
     * @covers h4kuna\Base64Array::hash
     * @todo   Implement testHash().
     */
    public function testFromArray()
    {
        $data = self::getArray();
        $base64 = new Base64Array($data);
        $this->assertSame('matejcek', $base64[1]);
        $this->assertSame(self::getHash(), $base64->hash());
    }

    public function testFromString()
    {
        $base64 = new Base64Array(self::getHash());
        $this->assertSame('matejcek', $base64[1]);
        $this->assertSame(self::getArray(), (array) $base64);
    }

}
