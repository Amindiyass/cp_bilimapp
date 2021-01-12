<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index()
    {
        return $this->sendResponse([
            [
                'id' => 1,
                'card' => '5169-49******-1954'
            ]
        ]);
    }
}
