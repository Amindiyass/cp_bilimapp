<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    public function index()
    {
        return $this->sendResponse([
            [
                'amount' => '15',
                'payment_type' => 'Qiwi',
                'finished_at' => 1620822432,
                'day_left' => 7,
                'processed_at' => 1610454432,
                'currency' => '₸',
                'finished' => '2021-01-11 11:11:11',
                'processed' => '2021-01-11 11:11:11'
            ]
        ]);
    }
}
