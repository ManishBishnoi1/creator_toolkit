<?php

namespace App\Modules\Subscription\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class StripeGateway
{
    /**
     * Create billing checkout session for premium plan.
     */
    public function createCheckoutSession(User $user, string $priceId): array
    {
        Log::info("Initiating Stripe Checkout Session for user ID: {$user->id}");

        // In real execution:
        // return $user->newSubscription('default', $priceId)
        //     ->checkout([
        //         'success_url' => route('billing.success'),
        //         'cancel_url' => route('billing.cancel'),
        //     ]);

        return [
            'session_id' => 'cs_test_mock_session_123',
            'url' => 'https://checkout.stripe.com/pay/cs_test_mock_session_123',
        ];
    }

    /**
     * Cancel subscription.
     */
    public function cancelSubscription(User $user): bool
    {
        Log::info("Canceling Stripe Subscription for user ID: {$user->id}");
        
        // In real execution:
        // $user->subscription('default')->cancel();
        
        return true;
    }
}
