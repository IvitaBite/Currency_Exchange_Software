<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use App\CurrencyAPI;
use App\Currency;

$apiKey = "fca_live_dmHa7eQd1co2DjrKCo0DRNxrI9lD44iHLAQNppts";

$baseCurrency = '';
$targetCurrency = '';
$amount = 0.0;

while (empty($baseCurrency) || empty($targetCurrency)) {
    $desiredInput = readline("Enter the desired amount and base currency (e.g., 100 USD): ");
    list($amount, $baseCurrency) = sscanf($desiredInput, "%f %s");

    if (empty($baseCurrency)) {
        echo "No base currency was entered. Try again.\n";
    } else {
        $targetCurrency = readline("Enter the target currency for conversion: ");

        if (empty($targetCurrency)) {
            echo "No target currency was entered. Try again.\n";
        } else {
            $baseCurrency = strtoupper($baseCurrency);
            $targetCurrency = strtoupper($targetCurrency);
        }
    }
}


$currencyAPI = new CurrencyAPI($apiKey);


$exchangeRate = $currencyAPI->getCurrencyExchangeRate($baseCurrency, $targetCurrency, $amount);
if ($exchangeRate !== null) {
    $convertedAmount = number_format($exchangeRate, 2);

    echo "$amount $baseCurrency is equal to $convertedAmount $targetCurrency.\n";
} else {
    echo "Currency not found in exchange rates or failed to fetch exchange rate data.\n";
}

