<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use App\Models\UserSubscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    public function user()
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
        /** @var Carbon $expired */
        $expired = $userSubscription->pivot->created_at
            ->addWeeks($userSubscription->duration_in_week)
            ->addMonths($userSubscription->duration_in_month)
            ->addYear($userSubscription->duration_in_year);
        return $this->sendResponse(['expired_at' => $expired->timestamp]);
    }

    public function index()
    {
        return $this->sendResponse(Subscription::all());
    }

    public function addForDev()
    {
        $user = auth()->user();
        UserSubscription::create([
            'user_id' => $user->id,
            'subscription_id' => 1,
            'is_active' => 1
        ]);
    }
}
