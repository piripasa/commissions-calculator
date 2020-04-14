<?php

namespace App\Entities;

class Commission
{
    private $euCommission;
    private $nonEuCommission;

    /**
     * Commission constructor.
     * @param string $type
     * @param float $euCommission
     * @param float $nonEuCommission
     */
    public function __construct(float $euCommission, float $nonEuCommission)
    {
        $this->setEuCommission($euCommission);
        $this->setNonEuCommission($nonEuCommission);
    }

    /**
     * @param float $euCommission
     */
    public function setEuCommission(float $euCommission)
    {
        $this->euCommission = $euCommission;
    }

    /**
     * @return float
     */
    public function getEuCommission(): float
    {
        return $this->euCommission;
    }

    /**
     * @param float $nonEuCommission
     */
    public function setNonEuCommission(float $nonEuCommission)
    {
        $this->nonEuCommission = $nonEuCommission;
    }

    /**
     * @return float
     */
    public function getNonEuCommission(): float
    {
        return $this->nonEuCommission;
    }
}