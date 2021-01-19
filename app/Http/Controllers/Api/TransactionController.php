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
                'amount' => '0',
                'payment_type' => 'Акция',
                'finished_at' => 1612042276,
                'day_left' => 14,
                'processed_at' => 1610659876,
                'currency' => '₸',
                'finished' => '2021-01-17 11:11:11',
                'processed' => '2021-01-17 11:11:11'
            ]
        ]);
    }
}
