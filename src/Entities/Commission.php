<?php

namespace App\Entities;

class Commission
{
    private $baseCommission;
    private $nonBaseCommission;

    /**
     * Commission constructor.
     * @param float $baseCommission
     * @param float $nonBaseCommission
     */
    public function __construct(float $baseCommission, float $nonBaseCommission)
    {
        $this->setBaseCommission($baseCommission);
        $this->setNonBaseCommission($nonBaseCommission);
    }

    /**
     * @param float $baseCommission
     */
    public function setBaseCommission(float $baseCommission)
    {
        $this->baseCommission = $baseCommission;
    }

    /**
     * @return float
     */
    public function getBaseCommission(): float
    {
        return $this->baseCommission;
    }

    /**
     * @param float $nonBaseCommission
     */
    public function setNonBaseCommission(float $nonBaseCommission)
    {
        $this->nonBaseCommission = $nonBaseCommission;
    }

    /**
     * @return float
     */
    public function getNonBaseCommission(): float
    {
        return $this->nonBaseCommission;
    }
}