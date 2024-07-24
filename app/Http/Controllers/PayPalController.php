<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function createTransaction()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->setAccessToken($provider->getAccessToken());

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00"
                    ]
                ]
            ]
        ]);

        return response()->json($order);
    }

    public function captureTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->setAccessToken($provider->getAccessToken());

        $result = $provider->capturePaymentOrder($request->token);

        return response()->json($result);
    }
}
