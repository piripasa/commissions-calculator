<?php

namespace App\Entities;

class Operation
{
    private $amount;
    private $currency;
    private $rate;
    private $isEu;

    /**
     * @param float $amount
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param bool $isEu
     */
    public function setIsEu(bool $isEu)
    {
        $this->isEu = $isEu;
    }

    /**
     * @return bool
     */
    public function getIsEu(): bool
    {
        return $this->isEu;
    }
}