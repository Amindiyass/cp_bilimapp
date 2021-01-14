<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactUsRequest;
use App\User;
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

    public function destroy()
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user->student) {
            $user->student->delete();
        }
        if ($user->subscriptions) {
            $subscriptions = $user->subscriptions;
            foreach ($subscriptions as $subscription) {
                $subscription->pivot->delete();
            }
        }
        $user->forceDelete();
        return $this->sendResponse([], 'User deleted');
    }
}
