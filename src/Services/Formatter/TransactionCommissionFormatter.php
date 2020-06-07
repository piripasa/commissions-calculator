<?php


namespace App\Services\Formatter;


class TransactionCommissionFormatter implements FormatterInterface
{
    /**
     * format given value
     * @param $value
     * @return string
     */
    public function format($value)
    {
        $rounded = ceil($value * 100) / 100;
        return number_format((float)$rounded, 2, '.', '');
    }
}