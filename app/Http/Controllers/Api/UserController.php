<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactUsRequest;
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

    public function contact(ContactUsRequest $request)
    {
        return $this->sendResponse('', 'Message delivered');
    }
}
