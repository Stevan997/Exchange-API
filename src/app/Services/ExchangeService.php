<?php

namespace App\Services;

use App\Mail\OrderCompleted;
use App\Models\Currency;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExchangeService
{
    /**
     * @param Request $request
     * @return array|string[]
     */
    public function exchange(Request $request): array
    {
        try {
            $amount = $request->get('amount');
            $currency = $request->get('currency');

            if (is_null($amount) || is_null($currency)) {
                return ['status' => 'fail', 'message' => 'There was a problem with request, please try again'];
            }
            $currency = Currency::where('name', $currency)->first();
            $currencyValue = $currency->values()->latest()->first();
            $calculatedValues = $this->calculate($amount, $currencyValue->value, $currency->surcharge_percentage);
            $orderArray = $this->parseOrderArray($currencyValue->id, $currency->surcharge_percentage, $calculatedValues, $amount, $currency->name);
            if ($request->get('ajax', false)) {
                return ['status' => 'success', 'amount' => $amount, 'paid' => round($orderArray['paid_amount'], 2), 'discount' => $orderArray['discount_amount']];
            }
            $id = $this->createOrder($orderArray);
            $this->additionalActions($currency->name, $id, $request->get('email'));
            return ['status' => 'success', 'amount' => $amount, 'paid' => round($orderArray['paid_amount'], 2), 'discount' => $orderArray['discount_amount']];
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * @param array $orderArray
     * @return int
     */
    private function createOrder(array $orderArray): int
    {
        return Order::query()->create($orderArray)->id;
    }

    /**
     * @param float $amount
     * @param float $currencyPrice
     * @param float $surcharge
     * @return array
     */
    private function calculate(float $amount, float $currencyPrice, float $surcharge): array
    {
        $price = $amount / $currencyPrice;
        $surchargeAmount = ($surcharge / 100) * $price;
        return [
            'total' => $price + $surchargeAmount,
            'surcharge' => $surchargeAmount,
            'withoutSurcharge' => $price
        ];
    }

    /**
     * @param string $currency
     * @param int $id
     * @param string|null $email
     */
    private function additionalActions(string $currency, int $id, ?string $email)
    {
        if ($currency == 'EUR' && !is_null($email)) {
            Mail::to($email)->send(new OrderCompleted(Order::where('id', $id)->with('currencyValue.currency')->first()->toArray()));
        }
    }

    /**
     * @param int $id
     * @param float $surcharge_percentage
     * @param array $values
     * @param float $amount
     * @param string $currency
     * @return array
     */
    private function parseOrderArray(int $id, float $surcharge_percentage, array $values, float $amount, string $currency): array
    {
        $discount = ($currency == 'EUR')? 2 : 0;
        $discount_amount = ($discount == 0)? 0 : ($discount / 100) * $values['total'];
        return [
            'currency_value_id' => $id,
            'surcharge_percentage' => $surcharge_percentage,
            'surcharge_amount' => $values['surcharge'],
            'purchased_amount' => $amount,
            'discount_percentage' => $discount,
            'discount_amount' => $discount_amount,
            'paid_amount' => $values['total'] - $discount_amount,
        ];
    }
}
