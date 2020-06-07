<?php

namespace App\Services\Checkers;

class EuChecker extends CheckerStrategy
{
    protected $param;

    const COUNTRY = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];

    /**
     * EuChecker constructor.
     * @param string $param
     */
    public function __construct(string $param)
    {
        $this->param = $param;
    }

    public function check()
    {
        return in_array($this->param, self::COUNTRY);
    }

}