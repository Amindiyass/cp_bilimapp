<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use App\User;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $subscriptions = $user->subscriptions()->get();
        return $this->sendResponse($subscriptions);
    }

    public function expiry()
    {
        /** @var User $user */
        $user = auth()->user();
        $userSubscription = $user->getActiveSubscription();
        return $this->sendResponse(['expired_at' => $userSubscription->pivot->created_at
            ->addWeeks($userSubscription->duration_in_week)
            ->addMonths($userSubscription->duration_in_month)
            ->addYear($userSubscription->duration_in_year)]);
    }
}
