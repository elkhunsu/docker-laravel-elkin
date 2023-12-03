<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array of currency names
        $currencies = [
            [
                "currency_code" => "USD",
                "currency_name" => "United State Dollar",
                "exchange_rate" => 1
            ],
            [
                "currency_code" => "IDR",
                "currency_name" => "Indonesian Rupiah",
                "exchange_rate" => 1
            ],
            [
                "currency_code" => "JPY",
                "currency_name" => "Japan Yen",
                "exchange_rate" => 1
            ],
            [
                "currency_code" => "EUR",
                "currency_name" => "Euro",
                "exchange_rate" => 1
            ],
            [
                "currency_code" => "GBP",
                "currency_name" => "Pound Sterling",
                "exchange_rate" => 1
            ],

        ];

        // Seed the currencies table
        foreach ($currencies as $currency) {
            Currency::create([
                'currency_code' => $currency['currency_code'],
                'currency_name' => $currency['currency_name'],
                'exchange_rate' => $currency['exchange_rate'],
            ]);
        }
    }
}
