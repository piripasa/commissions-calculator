<?php

namespace App\Services\Formatter;

interface FormatterInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function format($value);
}