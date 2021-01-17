<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Order;
use Dosarkz\Paybox\Facades\Paybox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function order(Subscription $subscription)
    {
        $user = auth()->user();
        $order = Order::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'amount' => $subscription->price,
            'status' => Order::STATUS_CREATED
        ]);
        return Paybox::generate([
            "x_idempotency_key" => Str::uuid()->toString(), // required
            'order' => 'ordered-'.$order->id,
            'amount' =>  5000, // required
            "refund_amount" => 0,
            "currency" => "KZT", // required
            "description" => "Description", // required
            // "payment_system"=> "string",
            "cleared" => true,
            "expires_at" => date('Y-m-d H:i:s', strtotime('+1 day')), // required
            "language" => "ru",
            'testing' => true,
            'test' => true,
            "options" => [
                "callbacks" => [
                    "result_url" => route('api.payment.check', ['order' => $order->id]),
              //      "check_url" => "string",
              //      "cancel_url" => "string",
                    "success_url" => "https://bilimapp.tk/callback-payment",
                    "failure_url" => "https://bilimapp.tk/callback-payment",
              //      "back_url"   => "string",
              //      "capture_url" => "string"
                ]
            ]
        ]);
    }

    public function check(Order $order)
    {
        Log::info(Paybox::paymentInfo($order->id));
        return Paybox::paymentInfo($order->id);
    }
}
