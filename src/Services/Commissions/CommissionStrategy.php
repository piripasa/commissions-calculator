<?php

namespace App\Services\Commissions;

abstract class CommissionStrategy
{
    abstract public function calculate();
}