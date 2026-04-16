<?php

namespace App\Actions\Subscriptions;

use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use Illuminate\Support\Facades\DB;

class ManageSubscriptionAction
{
    /**
     * Update or create a subscription and record the history.
     */
    public function execute(array $data, ?Subscription $subscription = null): Subscription
    {
        return DB::transaction(function () use ($data, $subscription) {
            $oldDetails = $subscription ? $subscription->toArray() : null;
            
            if ($subscription) {
                $subscription->update($data);
                $event = 'update';
            } else {
                $subscription = Subscription::create($data);
                $event = 'create';
            }

            SubscriptionHistory::create([
                'subscription_id' => $subscription->id,
                'event' => $event,
                'old_details' => $oldDetails,
                'new_details' => $subscription->toArray(),
            ]);

            return $subscription;
        });
    }
}
