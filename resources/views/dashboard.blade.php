<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Overview of your loan portfolio performance</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm font-bold text-slate-400 bg-slate-100 px-4 py-2 rounded-xl">
                    {{ now()->format('l, j F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Active Loans -->
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-[3rem] -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 shadow-inner shadow-indigo-200/50">
                    <i data-lucide="activity" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Active Loans') }}</p>
                <div class="flex items-baseline mt-2">
                    <p class="text-3xl font-black text-slate-800">{{ $report['total_active_loans'] }}</p>
                    <span class="ml-2 text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-lg">+2.5%</span>
                </div>
            </div>
        </div>

        <!-- Total Disbursed -->
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-[3rem] -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 shadow-inner shadow-emerald-200/50">
                    <i data-lucide="banknote" class="w-6 h-6 text-emerald-600"></i>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Total Disbursed') }}</p>
                <div class="flex items-baseline mt-2">
                    <p class="text-3xl font-black text-slate-800">P{{ number_format($report['total_principal_disbursed'] / 1000, 1) }}k</p>
                    <span class="ml-2 text-xs font-bold text-slate-500">Total Portfolio</span>
                </div>
            </div>
        </div>

        <!-- Pending Apps -->
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-xl hover:shadow-amber-500/5 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-[3rem] -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center mb-6 shadow-inner shadow-amber-200/50">
                    <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Pending Apps') }}</p>
                <div class="flex items-baseline mt-2">
                    <p class="text-3xl font-black text-slate-800">{{ $report['total_pending_applications'] }}</p>
                    <span class="ml-2 text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-lg">Review</span>
                </div>
            </div>
        </div>

        <!-- Delinquency Rate -->
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200/60 relative overflow-hidden group hover:shadow-xl hover:shadow-rose-500/5 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-[3rem] -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-rose-100 rounded-2xl flex items-center justify-center mb-6 shadow-inner shadow-rose-200/50">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-rose-600"></i>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Delinquency Rate') }}</p>
                <div class="flex items-baseline mt-2">
                    <p class="text-3xl font-black text-slate-800">{{ $report['delinquency_rate'] }}%</p>
                    <span class="ml-2 text-xs font-bold text-slate-500 italic">Target: <5%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Loans Table -->
        <div class="lg:col-span-2">
            <x-u-i.card class="h-full">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="font-black text-xl text-slate-800">{{ __('Recent Applications') }}</h3>
                        <p class="text-sm text-slate-400 font-medium">Most recent loan requests</p>
                    </div>
                    <a href="{{ route('loans.index') }}" class="inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-4 py-2 rounded-xl transition-all">
                        {{ __('View All') }}
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left">
                                <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Customer') }}</th>
                                <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Amount') }}</th>
                                <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-center">{{ __('Status') }}</th>
                                <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentLoans as $loan)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-2">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center mr-3 font-black text-slate-400 text-xs group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                                {{ substr($loan->customer->first_name, 0, 1) }}{{ substr($loan->customer->last_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-700">{{ $loan->customer->full_name }}</p>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $loan->customer->id_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <p class="text-sm font-black text-slate-700">P{{ number_format($loan->principal_amount, 2) }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold tracking-tight">{{ $loan->term_months }} Months @ {{ $loan->interest_rate }}%</p>
                                    </td>
                                    <td class="py-4 px-2 text-center">
                                        <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-blue-100 text-blue-700">
                                            {{ $loan->loan_status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <a href="{{ route('loans.show', $loan) }}" class="p-2 text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all inline-block">
                                            <i data-lucide="eye" class="w-5 h-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4">
                                                <i data-lucide="inbox" class="w-8 h-8 text-slate-200"></i>
                                            </div>
                                            <p class="text-slate-400 font-bold text-sm">{{ __('No applications found') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-u-i.card>
        </div>

        <!-- Quick Links -->
        <div class="lg:col-span-1 space-y-8">
            <x-u-i.card class="bg-indigo-900 border-none shadow-xl shadow-indigo-200">
                <h3 class="font-black text-xl text-white mb-6">{{ __('Quick Actions') }}</h3>
                <div class="space-y-4">
                    <button onclick="window.location='{{ route('customers.create') }}'" class="w-full flex items-center justify-between p-4 bg-white/10 hover:bg-white/20 rounded-2xl text-white transition-all group active:scale-[0.98]">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mr-4">
                                <i data-lucide="user-plus" class="w-5 h-5"></i>
                            </div>
                            <span class="text-sm font-bold tracking-tight">Onboard Customer</span>
                        </div>
                        <i data-lucide="chevron-right" class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </button>

                    <button onclick="window.location='{{ route('loans.create') }}'" class="w-full flex items-center justify-between p-4 bg-indigo-600 hover:bg-indigo-500 rounded-2xl text-white transition-all group shadow-lg shadow-indigo-950/20 active:scale-[0.98]">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mr-4">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                            </div>
                            <span class="text-sm font-bold tracking-tight">New Loan App</span>
                        </div>
                        <i data-lucide="chevron-right" class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </button>
                </div>
            </x-u-i.card>

            <x-u-i.card class="bg-slate-50 border-slate-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-200 shadow-sm">
                        <i data-lucide="help-circle" class="w-5 h-5 text-slate-400"></i>
                    </div>
                    <h3 class="font-black text-lg text-slate-800">{{ __('Support') }}</h3>
                </div>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">
                    Need help managing the portfolio or processing an application?
                </p>
                <x-u-i.button variant="secondary" class="w-full justify-center">
                    {{ __('View Documentation') }}
                </x-u-i.button>
            </x-u-i.card>
        </div>
    </div>
</x-layouts.app>
