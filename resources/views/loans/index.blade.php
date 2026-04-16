<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Loans Portfolio') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Manage and monitor all loan applications</p>
            </div>
            @can('create', App\Models\Loan::class)
                <x-u-i.button onclick="window.location='{{ route('loans.create') }}'">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    {{ __('New Loan') }}
                </x-u-i.button>
            @endcan
        </div>
    </x-slot>

    <x-u-i.card>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-slate-100">
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Customer') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Loan Details') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-center">{{ __('Status') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($loans as $loan)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="py-6 px-2">
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
                            <td class="py-6 px-2">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-700">P{{ number_format($loan->principal_amount, 2) }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold tracking-tight uppercase">
                                        {{ $loan->term_months }} Months @ {{ $loan->interest_rate }}%
                                    </span>
                                </div>
                            </td>
                            <td class="py-6 px-2 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'approved' => 'bg-blue-100 text-blue-700',
                                        'disbursed' => 'bg-indigo-100 text-indigo-700',
                                        'active' => 'bg-emerald-100 text-emerald-700',
                                        'delinquent' => 'bg-rose-100 text-rose-700',
                                        'closed' => 'bg-slate-100 text-slate-500',
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full {{ $statusClasses[$loan->loan_status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $loan->loan_status }}
                                </span>
                            </td>
                            <td class="py-6 px-2 text-right">
                                <a href="{{ route('loans.show', $loan) }}" class="p-2 text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all inline-block">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-4">
                                        <i data-lucide="banknote" class="w-10 h-10 text-slate-200"></i>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800">No loans found</h3>
                                    <p class="text-sm text-slate-400 font-medium mt-1">There are no loan applications to display at this time.</p>
                                    @can('create', App\Models\Loan::class)
                                        <x-u-i.button variant="secondary" class="mt-6" onclick="window.location='{{ route('loans.create') }}'">
                                            New Application
                                        </x-u-i.button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($loans->hasPages())
            <div class="mt-8 pt-8 border-t border-slate-100">
                {{ $loans->links() }}
            </div>
        @endif
    </x-u-i.card>
</x-layouts.app>
