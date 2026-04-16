<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-10">
            <div class="flex items-center space-x-4">
                <a href="{{ route('subscriptions.index') }}" class="w-10 h-10 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Subscription Details</h1>
                    <p class="text-slate-500 font-medium mt-1">ID: #{{ $subscription->id }} &middot; Plan: {{ $subscription->plan_name }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                @php
                    $statusClasses = [
                        'active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                        'suspended' => 'bg-amber-50 text-amber-600 border-amber-100',
                        'cancelled' => 'bg-slate-50 text-slate-500 border-slate-100',
                        'expired' => 'bg-rose-50 text-rose-600 border-rose-100',
                    ];
                    $class = $statusClasses[$subscription->status] ?? 'bg-slate-50 text-slate-500 border-slate-100';
                @endphp
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest border {{ $class }}">
                    {{ $subscription->status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Update Form -->
                <x-u-i.card>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-lg font-bold text-slate-900">Update Subscription</h2>
                    </div>

                    <form action="{{ route('subscriptions.update', $subscription) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                            <div>
                                <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Status</label>
                                <select name="status" id="status" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all font-medium appearance-none">
                                    <option value="active" {{ $subscription->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ $subscription->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="cancelled" {{ $subscription->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="expired" {{ $subscription->status === 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </div>

                            <x-form.input name="plan_name" label="Plan Name" :value="$subscription->plan_name" required />
                            <x-form.input name="max_users" label="Max Users" type="number" :value="$subscription->max_users" required />
                            <x-form.input name="max_loans_per_month" label="Max Loans Per Month" type="number" :value="$subscription->max_loans_per_month" required />
                            <x-form.input name="expires_at" label="Expiration Date" type="date" :value="$subscription->expires_at ? $subscription->expires_at->format('Y-m-d') : ''" />
                        </div>

                        <div class="flex items-center justify-end pt-8 border-t border-slate-100">
                            <x-u-i.button variant="primary">
                                Save Changes
                            </x-u-i.button>
                        </div>
                    </form>
                </x-u-i.card>

                <!-- History Timeline -->
                <x-u-i.card>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-lg font-bold text-slate-900">Activity History</h2>
                    </div>

                    <div class="space-y-8 relative before:absolute before:left-5 before:top-2 before:bottom-2 before:w-px before:bg-slate-100">
                        @foreach($subscription->histories as $history)
                            <div class="relative pl-12">
                                <div class="absolute left-0 top-1 w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center shadow-sm">
                                    @if($history->event === 'create')
                                        <i data-lucide="plus" class="w-5 h-5 text-emerald-500"></i>
                                    @else
                                        <i data-lucide="refresh-cw" class="w-5 h-5 text-indigo-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-bold text-slate-900">
                                            @if($history->event === 'create')
                                                Subscription Created
                                            @else
                                                Subscription Updated
                                            @endif
                                        </h4>
                                        <span class="text-xs font-medium text-slate-400">
                                            {{ $history->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                    <div class="mt-2 p-4 bg-slate-50/50 rounded-2xl border border-slate-100/50">
                                        <div class="grid grid-cols-2 gap-4 text-xs">
                                            <div>
                                                <span class="font-bold text-slate-400 uppercase tracking-widest">New Status:</span>
                                                <span class="ml-2 font-bold text-slate-700 capitalize">{{ $history->new_details['status'] ?? 'N/A' }}</span>
                                            </div>
                                            <div>
                                                <span class="font-bold text-slate-400 uppercase tracking-widest">Plan:</span>
                                                <span class="ml-2 font-bold text-slate-700">{{ $history->new_details['plan_name'] ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-u-i.card>
            </div>

            <!-- Summary Sidebar -->
            <div class="space-y-8">
                <x-u-i.card>
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-6">Current Limits</h3>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-500">Max Users</span>
                            <span class="text-sm font-bold text-slate-900">{{ $subscription->max_users }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-500">Loans / Month</span>
                            <span class="text-sm font-bold text-slate-900">{{ $subscription->max_loans_per_month }}</span>
                        </div>
                        <div class="pt-6 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-500">Expires At</span>
                            <span class="text-sm font-bold text-slate-900">
                                {{ $subscription->expires_at ? $subscription->expires_at->format('d M Y') : 'Never' }}
                            </span>
                        </div>
                    </div>
                </x-u-i.card>

                <x-u-i.card class="bg-indigo-600 text-white border-none shadow-indigo-100">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
                            <i data-lucide="crown" class="w-6 h-6 text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold">Premium Support</h3>
                        <p class="text-white/80 text-sm mt-1">This tenant has access to enterprise priority support and dedicated success manager.</p>
                        <button class="mt-6 w-full py-3 bg-white text-indigo-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-colors">
                            Contact Support
                        </button>
                    </div>
                </x-u-i.card>
            </div>
        </div>
    </div>
</x-layouts.app>
