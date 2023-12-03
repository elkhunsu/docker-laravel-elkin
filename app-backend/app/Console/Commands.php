<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateExchangeRates extends Command
{
  protected $signature = 'exchange-rates:update';
  protected $description = 'Update exchange rates for currencies';
  //build automation not finished
  public function handle()
  {
    $response = Http::get('https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/jpy/idr.json');

    if ($response->successful()) {
      $exchangeRates = $response->json();

      foreach ($exchangeRates as $currencyCode => $rate) {
        $currency = Currency::where('currency_name', $currencyCode)->first();

        if ($currency) {
          $currency->update(['exchange_rate' => $rate]);
          $this->info("Exchange rate for {$currencyCode} updated: {$rate}");
        } else {
          // Handle if the currency code is not found in your currencies table
        }
      }
    } else {
      $this->error('Failed to fetch exchange rates from the API.');
    }
  }
}
