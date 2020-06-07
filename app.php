<?php

require_once 'vendor/autoload.php';

use App\Entities\Commission;
use App\Entities\Operation;
use App\Services\Formatter\TransactionCommissionFormatter;
use App\Services\Currency;
use App\Services\Commissions\TransactionCommission;
use App\Services\Checkers\EuChecker;
use App\Services\Readers\FileReader;
use App\Services\Providers\BinList;
use App\Services\Providers\ExchangeRates;
use GuzzleHttp\Client as HttpClient;


$file = new FileReader($argv[1]);
$file->read();
$lookupApi = new BinList(new HttpClient(), 'https://lookup.binlist.net/');
$rateApi = new ExchangeRates(new HttpClient(), 'https://api.exchangeratesapi.io/');
$rateApi->setUri('latest');
$rates = $rateApi->getTransformed();
$commission = new Commission(0.01, 0.02);
$currency = new Currency('EUR');
$formatter = new TransactionCommissionFormatter();
foreach ($file->getData() as $key => $value) {
    $lookupApi->setUri($value['bin']);
    $country = $lookupApi->getTransformed();
    $euChecker = new EuChecker($country['alpha2']);

    $rate = $rates[$value['currency']] ?? 0;

    $operation = new Operation();
    $operation->setAmount($value['amount']);
    $operation->setCurrency($value['currency']);
    $operation->setRate($rate);

    $transactionCommission = new TransactionCommission($operation, $commission, $currency, $euChecker);
    echo $formatter->format($transactionCommission->calculate()); //formatted result
    print "\n";
}