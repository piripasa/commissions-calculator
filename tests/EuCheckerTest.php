<?php

namespace Tests;

use App\Services\Checkers\EuChecker;
use PHPUnit\Framework\TestCase;


class EuCheckerTest extends TestCase
{
    public function testParamShouldNotNUll()
    {
        $this->expectException(\TypeError::class);
        new EuChecker(null);
    }

    public function testShouldReturnTrue()
    {
        $checker = new EuChecker('LT');
        $this->assertTrue($checker->check());
    }

    public function testShouldReturnFalse()
    {
        $checker = new EuChecker('BD');
        $this->assertFalse($checker->check());
    }

}