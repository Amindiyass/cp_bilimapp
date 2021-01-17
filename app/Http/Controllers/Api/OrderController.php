<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Order;
use Dosarkz\Paybox\Facades\Paybox;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends BaseController
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
        $request = [
            'pg_merchant_id'=> config('paybox.merchant_id'),
            'pg_amount' => $order->amount,
            'pg_salt' => Str::random(),
            'pg_order_id' => $order->id,
            'pg_payment_system' => 'EPAYKZT',
            'pg_description' => 'Описание заказа',
            'pg_result_url' => route('api.paybox.payment.result'),
            //'pg_testing_mode' => 1
        ];

        ksort($request); //sort alphabetically
        array_unshift($request, 'init_payment.php');
        array_push($request, config('paybox.secret_key')); //add your secret key (you can take it in your personal cabinet on paybox system)

        $request['pg_sig'] = md5(implode(';', $request));

        unset($request[0], $request[1]);

        $query = http_build_query($request);
        // dd($request);
        $client = new Client();
        $response = $client->post('https://api.paybox.money/init_payment.php', [
            'form_params' => $request,
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);
        $response = $response->getBody()->getContents();
        $response = simplexml_load_string($response);
        // dd($response->pg_redirect_url);
        if ((string)$response->pg_status === 'ok') {
            return $this->sendResponse([
                'redirect_url' => (string) $response->pg_redirect_url,
                'payment_id'   => (string) $response->pg_payment_id,
            ]);
        }
        dd($response);
        Log::error($response);
        abort(500, 'Payment system error');
//        return Paybox::generate([
//            "x_idempotency_key" => Str::uuid()->toString(), // required
//            'order' => ''.$order->id,
//            'amount' =>  5000, // required
//            "refund_amount" => 0,
//            "currency" => "KZT", // required
//            "description" => "Description", // required
//            // "payment_system"=> "string",
//            "cleared" => true,
//            "expires_at" => date('Y-m-d H:i:s', strtotime('+1 day')), // required
//            "language" => "ru",
//            'testing' => true,
//            'test' => true,
//            "options" => [
//                "callbacks" => [
//                    "result_url" => route('api.payment.check', ['order' => $order->id]),
//              //      "check_url" => "string",
//              //      "cancel_url" => "string",
//                    "success_url" => "https://bilimapp.tk/callback-payment/".$order->id,
//                    "failure_url" => "https://bilimapp.tk/callback-payment/".$order->id,
//              //      "back_url"   => "string",
//              //      "capture_url" => "string"
//                ]
//            ]
//        ]);
    }

    public function check(Order $order, $paymentId)
    {
        $info = Paybox::paymentInfo($paymentId);
        Log::info($info);
        if (isset($info->response->status->code)) {
            $status = $info->response->status->code;
            if ($status === 'ok') {
                $order->status = Order::STATUS_SUCCESS;
                $order->save();
            }
        }
        return $this->sendResponse($order);
    }

    public function checkResult(Request $request)
    {
        Log::info('Paybox result');
        Log::info($request->all());
    }
}
