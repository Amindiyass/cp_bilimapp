<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Subscription $subscription)
    {
        $user = auth()->user();
        $order = Order::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'amount' => $subscription->price
        ]);
        return Paybox::generate([
            "x_idempotency_key" => 'UUID of order', // required
            'order' => "my-super",
            'amount' =>  20, // required
            "refund_amount" => 0,
            "currency" => "KZT", // required
            "description" =>"Description", // required
            "payment_system"=> "string",
            "cleared" => true,
            "expires_at" => "Date", // required
            "language" => "ru",
            "param1" => "string",
            "param2" => "string",
            "param3" => "string",
            "options" => [
                "callbacks" => [
                    "result_url" => "string",
                    "check_url" => "string",
                    "cancel_url" => "string",
                    "success_url" => "string",
                    "failure_url" => "string",
                    "back_url"   => "string",
                    "capture_url" => "string"
                ]
            ]
        ]);
    }
}
