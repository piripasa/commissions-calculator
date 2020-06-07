<?php

namespace App\Services;

class Currency
{
    private $code;

    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        if ($code === '') {
            throw new \InvalidArgumentException('Currency code should not be empty string');
        }

        $this->code = $code;
    }

    /**
     * Return the currency code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Checks whether this currency is the same as an other.
     *
     * @param Currency $other
     *
     * @return bool
     */
    public function equals(Currency $other): bool
    {
        return $this->code === $other->code;
    }
}