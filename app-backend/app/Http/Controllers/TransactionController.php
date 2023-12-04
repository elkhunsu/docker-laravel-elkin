<?php

namespace App\Http\Controllers;

use App\Models\BuyTransaction;
use App\Models\Currency;
use App\Models\SellTransaction;
use App\Models\TransactionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function buyCurrency(Request $request)
    {
        $userId = Auth::user()->user_id;
        if (!$userId) {
            return response()->json(
                [
                    "message" => "must login",
                ],
            );
        }
        $input = $request->only(['currency_code', 'amount', 'total_amount']);
        $currencyid = Currency::where('currency_code', $input['currency_code'])->first()->currency_id;

        $buyTransaction = new BuyTransaction([
            'user_id' => $userId,
            'currency_id' => $currencyid,
            'amount' => $input['amount'],
            'total_amount' => $input['total_amount'],
            'timestamp' => now(),
            'notification' => 'Transaction created for buying currency.',
        ]);

        $buyTransaction->save();

        $buyTransaction['type_transaction'] = 'buy';
        $buyTransaction['exchange_rate_used'] = $input['total_amount'] / $input['amount'];

        $this->logTransaction($buyTransaction);

        return response()->json(['message' => 'Transaction created successfully', 'transaction' => $buyTransaction], 201);
    }

    public function sellCurrencies(Request $request)
    {

        $userId = Auth::user()->user_id;
        if (!$userId) {
            return response()->json(
                [
                    "message" => "must login",
                ],
            );
        }

        $input = $request->only(['currency_code', 'amount', 'total_amount']);
        $currencyid = Currency::where('currency_code', $input['currency_code'])->first()->currency_id;
        $transaction = new SellTransaction([
            'user_id' => $userId,
            'currency_id' => $currencyid,
            'amount' => $input['amount'],
            'total_amount' => $input['total_amount'],
            'timestamp' => now(),
            'notification' => 'Transaction created for selling currency.',
        ]);


        $transaction->save();
        $transaction['type_transaction'] = 'sell';
        $transaction['exchange_rate_used'] = $input['total_amount'] / $input['amount'];

        $this->logTransaction($transaction);

        return response()->json(['message' => 'Sell transaction created successfully', 'transaction' => $transaction], 201);
    }

    public function summary(Request $request)
    {
        $userId = Auth::user()->user_id;
        if (!$userId) {
            return response()->json(
                [
                    "message" => "must login",
                ],
            );
        }

        $timeInterval = $request->input('interval', 'month');
        $startDate = Carbon::now();
        $endDate = Carbon::now();

        if ($timeInterval === 'week') {
            $startDate->startOfWeek();
            $endDate->endOfWeek();
        } elseif ($timeInterval === 'month') {
            $startDate->startOfMonth();
            $endDate->endOfMonth();
        }

        $totalBuy = BuyTransaction::where('amount', '>', 0)
            ->where('user_id', $userId)
            ->whereBetween('timestamp', [$startDate, $endDate])
            ->groupBy('currency_id')
            ->selectRaw('currency_id, sum(amount) as total_buy')
            ->get();

        $totalSell = SellTransaction::where('amount', '<', 0)
            ->where('user_id', $userId)
            ->whereBetween('timestamp', [$startDate, $endDate])
            ->groupBy('currency_id')
            ->selectRaw('currency_id, sum(amount) as total_sell')
            ->get();

        $summary = collect($totalBuy)->merge($totalSell)->groupBy('currency_id')->map(function ($item) {
            return [
                'currency_id' => $item[0]->currency_id,
                'total_buy' => $item->sum('total_buy'),
                'total_sell' => abs($item->sum('total_sell')),
                'available_amount' => $item->sum('total_buy') + abs($item->sum('total_sell')),
            ];
        });

        return response()->json(['summary' => $summary]);
    }

    private function logTransaction($transaction)
    {
        TransactionLog::create([
            'currency_id' => $transaction->currency_id,
            'exchange_rate_used' => $transaction->exchange_rate_used,
            'transaction_id' => $transaction->transaction_id,
            'user_id' => $transaction->user_id,
            'type_transaction' => $transaction->type_transaction,
            'timestamp' => $transaction->timestamp,
            'log_message' => 'Transaction logged successfully.',
        ]);
    }
}
