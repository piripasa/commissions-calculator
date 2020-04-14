<?php
namespace App\Services\Providers;

use GuzzleHttp\Client;

class BinList extends Provider
{
    public function __construct(Client $client, string $baseUri, array $headers = [])
    {
        parent::__construct($client, $baseUri, $headers);
    }

    /**
     * Transform api response as per need
     * @return array
     */
    public function getTransformed() : array
    {
        return json_decode($this->getData(), 1)['country'];
    }
}