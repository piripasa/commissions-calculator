<?php

namespace App\Services\Commissions;

use App\Entities\Commission;
use App\Entities\Operation;

class TransactionCommission extends CommissionStrategy
{
    /**
     * TransactionCommission constructor.
     * @param Operation $operation
     * @param Commission $commission
     */
    public function __construct(Operation $operation, Commission $commission)
    {
        parent::__construct($operation, $commission);
    }

    public function calculate()
    {
        $amount = $this->operation->getAmount();
        if ($this->operation->getCurrency() != 'EUR' and $this->operation->getRate() > 0) {
            $amount = $this->operation->getAmount() / $this->operation->getRate();
        }

        return $amount * ($this->operation->getIsEu() ? $this->commission->getEuCommission() : $this->commission->getNonEuCommission());
    }

    public function format($result): string
    {
        $rounded = ceil($result * 100) / 100;
        return number_format((float)$rounded, 2, '.', '');
    }
}