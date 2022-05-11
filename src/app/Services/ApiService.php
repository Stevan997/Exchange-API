<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiService
{
    private Client $client;
    private $endpoint;
    private array $headers = [];

    private string $usd = 'USD';
    private string $exchange_endpoint = 'currency_data/convert';

    public function __construct()
    {
        $this->client = new Client();
        $this->endpoint = env('API_LAYER_ENDPOINT');
        $this->headers['apikey'] = env('API_KEY');
    }

    /**
     * @param string $currency
     * @return array|false[]
     */
    public function getLiveCurrencyData(string $currency): array
    {
        try {
            $res = $this->client->get($this->endpoint . $this->exchange_endpoint, [
                'headers' => $this->headers,
                'query' => [
                    'amount' => 1,
                    'to' => $currency,
                    'from' => $this->usd
                ]
            ]);
            return (array)json_decode($res->getBody()->getContents());
        } catch (GuzzleException $exception) {
            return ['success' => false];
        }
    }
}
