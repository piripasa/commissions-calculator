<?php

namespace Tests;

use App\Services\Currency;
use PHPUnit\Framework\TestCase;


class CurrencyTest extends TestCase
{
    public function testParamShouldNotNUll()
    {
        $this->expectException(\TypeError::class);
        new Currency(null);
    }

    public function testShouldReturnString()
    {
        $object = new Currency('EUR');
        $this->assertEquals('EUR', $object->getCode());
    }

    public function testShouldCheckEquals()
    {
        $object = new Currency('EUR');
        $this->assertTrue($object->equals($object));
    }

    public function testShouldCheckNotEquals()
    {
        $object = new Currency('EUR');
        $this->assertFalse($object->equals(new Currency('BDT')));
    }
}