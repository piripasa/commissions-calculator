<?php

namespace Tests;

use App\Entities\Commission;
use App\Entities\Operation;
use App\Services\Checkers\EuChecker;
use App\Services\Commissions\TransactionCommission;
use App\Services\Currency;
use PHPUnit\Framework\TestCase;

class TransactionCommissionTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testCommissionWithValidArgument()
    {
        $knownResult = 1.666666666666667;
        $operation = new Operation();
        $operation->setAmount(100);
        $operation->setCurrency('BDT');
        $operation->setRate(1.20);

        $object = new TransactionCommission(
            $operation,
            new Commission(0.01, 0.02),
            new Currency('EUR'),
            new EuChecker('BD')
        );
        $this->assertEquals($knownResult, $object->calculate());
    }

    public function testCommissionForEu()
    {
        $knownResult = 1.00;
        $operation = new Operation();
        $operation->setAmount(100);
        $operation->setCurrency('EUR');
        $operation->setRate(1.20);
        $object = new TransactionCommission(
            $operation,
            new Commission(0.01, 0.02),
            new Currency('EUR'),
            new EuChecker('DE')
        );
        $this->assertEquals($knownResult, $object->calculate());
    }

    public function testCommissionForNonEu()
    {
        $knownResult = 1.666666666666667;
        $operation = new Operation();
        $operation->setAmount(100);
        $operation->setCurrency('BDT');
        $operation->setRate(1.20);
        $object = new TransactionCommission(
            $operation,
            new Commission(0.01, 0.02),
            new Currency('EUR'),
            new EuChecker('BD')
        );
        $this->assertEquals($knownResult, $object->calculate());
    }

    public function testCommissionWithInvalidOperation()
    {
        $this->expectException(\TypeError::class);
        new TransactionCommission(
            new \stdClass(),
            new Commission(0.01, 0.02),
            new Currency('EUR'),
            new EuChecker('BD')
        );
    }

    public function testCommissionWithInvalidCommission()
    {
        $operation = new Operation();
        $operation->setAmount(100);
        $operation->setCurrency('BDT');
        $operation->setRate(1.20);
        $this->expectException(\TypeError::class);
        new TransactionCommission(
            $operation,
            new \stdClass(),
            new Currency('EUR'),
            new EuChecker('BD')
        );
    }
}