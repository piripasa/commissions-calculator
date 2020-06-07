<?php

namespace App\Services\Commissions;

use App\Entities\Commission;
use App\Entities\Operation;
use App\Services\Checkers\CheckerStrategy;
use App\Services\Currency;

class TransactionCommission extends CommissionStrategy
{
    protected $operation;
    protected $commission;
    protected $currency;
    protected $checkerStrategy;

    /**
     * TransactionCommission constructor.
     * @param Operation $operation
     * @param Commission $commission
     * @param Currency $currency
     * @param CheckerStrategy $checkerStrategy
     */
    public function __construct(Operation $operation, Commission $commission, Currency $currency, CheckerStrategy $checkerStrategy)
    {
        $this->operation = $operation;
        $this->commission = $commission;
        $this->currency = $currency;
        $this->checkerStrategy = $checkerStrategy;
    }

    public function calculate()
    {
        $amount = $this->operation->getAmount();
        if (!$this->currency->equals(new Currency($this->operation->getCurrency())) and $this->operation->getRate() > 0) {
            $amount = $this->operation->getAmount() / $this->operation->getRate();
        }

        return $amount * ($this->checkerStrategy->check() ? $this->commission->getBaseCommission() : $this->commission->getNonBaseCommission());
    }
}