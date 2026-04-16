<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Actions\Subscriptions\ManageSubscriptionAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     */
    public function index()
    {
        Gate::authorize('viewAny', Subscription::class);

        $subscriptions = Subscription::withCount('histories')
            ->latest()
            ->paginate(10);

        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Display the specified subscription.
     */
    public function show(Subscription $subscription)
    {
        Gate::authorize('view', $subscription);

        $subscription->load(['histories' => function ($query) {
            $query->latest();
        }]);

        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Update the subscription status.
     */
    public function update(Request $request, Subscription $subscription, ManageSubscriptionAction $manageSubscriptionAction)
    {
        Gate::authorize('update', $subscription);

        $validated = $request->validate([
            'status' => 'required|string|in:active,suspended,cancelled,expired',
            'plan_name' => 'nullable|string|max:255',
            'max_users' => 'nullable|integer|min:1',
            'max_loans_per_month' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $manageSubscriptionAction->execute($validated, $subscription);

        return redirect()->route('subscriptions.show', $subscription)
            ->with('success', 'Subscription updated successfully.');
    }
}
