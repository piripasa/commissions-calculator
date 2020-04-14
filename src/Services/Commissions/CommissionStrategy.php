<?php

namespace App\Services\Commissions;

use App\Entities\Commission;
use App\Entities\Operation;

abstract class CommissionStrategy
{
    protected $operation;
    protected $commission;

    /**
     * CommissionStrategy constructor.
     * @param Operation $operation
     * @param Commission $commission
     */
    public function __construct(Operation $operation, Commission $commission)
    {
        $this->operation = $operation;
        $this->commission = $commission;
    }

    abstract public function calculate();
}