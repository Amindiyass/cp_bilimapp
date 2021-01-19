<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    public function index()
    {
        return $this->sendResponse([
            /*[
                'title' => 'У нас акция 50%, только для тебя!',
                'description' => 'Успей купить подписку до конца января и получи скидку 50%'
            ]*/
        ]);
    }
}
