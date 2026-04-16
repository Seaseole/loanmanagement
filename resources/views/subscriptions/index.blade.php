<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Subscriptions</h1>
                <p class="text-slate-500 font-medium mt-1">Manage platform access and limits</p>
            </div>
        </div>

        <x-u-i.card>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="pb-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Tenant / Details</th>
                            <th class="pb-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Plan</th>
                            <th class="pb-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Status</th>
                            <th class="pb-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Limits (Users/Loans)</th>
                            <th class="pb-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Expires At</th>
                            <th class="pb-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($subscriptions as $subscription)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold mr-4">
                                            {{ strtoupper(substr($subscription->plan_name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900">ID: #{{ $subscription->id }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5">{{ $subscription->histories_count }} history records</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 text-center">
                                    <span class="text-sm font-semibold text-slate-700">{{ $subscription->plan_name }}</span>
                                </td>
                                <td class="py-5 text-center">
                                    @php
                                        $statusClasses = [
                                            'active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'suspended' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'cancelled' => 'bg-slate-50 text-slate-500 border-slate-100',
                                            'expired' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ];
                                        $class = $statusClasses[$subscription->status] ?? 'bg-slate-50 text-slate-500 border-slate-100';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $class }}">
                                        {{ $subscription->status }}
                                    </span>
                                </td>
                                <td class="py-5 text-center">
                                    <div class="text-sm font-semibold text-slate-700">
                                        {{ $subscription->max_users }} / {{ $subscription->max_loans_per_month }}
                                    </div>
                                </td>
                                <td class="py-5 text-center">
                                    <div class="text-sm font-semibold text-slate-700">
                                        {{ $subscription->expires_at ? $subscription->expires_at->format('d/m/Y') : 'Never' }}
                                    </div>
                                </td>
                                <td class="py-5 text-right">
                                    <a href="{{ route('subscriptions.show', $subscription) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                                            <i data-lucide="shield-alert" class="w-8 h-8 text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">No subscriptions found</h3>
                                        <p class="text-slate-500 mt-1 max-w-xs">There are no active subscriptions in the system at this moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $subscriptions->links() }}
            </div>
        </x-u-i.card>
    </div>
</x-layouts.app>
