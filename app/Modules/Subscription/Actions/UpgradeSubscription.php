<?php

namespace App\Modules\Subscription\Actions;

use App\Core\Enums\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UpgradeSubscription
{
    /**
     * Execute the subscription upgrade.
     */
    public function execute(User $user, SubscriptionPlan $plan): bool
    {
        Log::info("Upgrading user subscription", [
            'user_id' => $user->id,
            'current_plan' => $user->subscription_plan ?? 'free',
            'new_plan' => $plan->value,
        ]);

        // In a real application, you would:
        // 1. Update the database column
        // 2. Clear user session / cache
        // 3. Fire custom event (e.g. UserSubscribedEvent)
        
        $user->forceFill([
            'subscription_plan' => $plan->value,
        ])->save();

        return true;
    }
}
