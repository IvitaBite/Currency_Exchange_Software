<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;

class CurrencyAPI
{
    private string $apiKey;
    private string $apiUrl = "https://api.freecurrencyapi.com/v1/latest";
    private Client $client;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client();
    }

    public function getCurrencyExchangeRate(string $baseCurrency, string $targetCurrency, float $amount): ?float
    {
        $url = "{$this->apiUrl}?apikey={$this->apiKey}&currencies={$targetCurrency},{$baseCurrency}";

        $params = [];

        $response = $this->client->request('GET', $url, $params);
        $content = $response->getBody()->getContents();

        if (empty($content)) {
            return null;
        }

        $data = json_decode($content, true);

        if ($data === null) {
            return null;
        }

        if (isset($data['data'])) {
            $rates = $data['data'];

            if (isset($rates[$baseCurrency]) && isset($rates[$targetCurrency])) {
                $baseCurrencyInstance = new Currency($rates[$baseCurrency], $baseCurrency);
                $targetCurrencyInstance = new Currency($rates[$targetCurrency], $targetCurrency);

                $exchangeRateBaseToTarget = $targetCurrencyInstance->getRate() / $baseCurrencyInstance->getRate();
                $convertedAmount = $amount * $exchangeRateBaseToTarget;

                return $convertedAmount;
            }
        }
        return null;
    }
}
