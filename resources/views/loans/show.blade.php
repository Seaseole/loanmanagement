<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Loan Details') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Manage and review loan application #{{ $loan->id }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('loans.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-slate-700 bg-slate-100 px-4 py-2 rounded-xl transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    {{ __('Back to List') }}
                </a>
                @can('approve', $loan)
                    @if($loan->loan_status === 'pending')
                        <form action="{{ route('loans.approve', $loan) }}" method="POST">
                            @csrf
                            <x-u-i.button variant="success">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                {{ __('Approve Loan') }}
                            </x-u-i.button>
                        </form>
                    @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Loan Status Card -->
            <x-u-i.card class="bg-indigo-900 border-none shadow-xl shadow-indigo-200">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                        <i data-lucide="info" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="px-4 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-white/20 text-white">
                        {{ $loan->loan_status }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-white/60 text-xs font-bold uppercase tracking-widest">Principal Amount</p>
                    <p class="text-3xl font-black text-white">P{{ number_format($loan->principal_amount, 2) }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-white/10">
                    <div>
                        <p class="text-white/40 text-[10px] font-bold uppercase tracking-widest">Interest</p>
                        <p class="text-white font-black">{{ $loan->interest_rate }}% <span class="text-[10px] font-medium opacity-60">p.a.</span></p>
                    </div>
                    <div>
                        <p class="text-white/40 text-[10px] font-bold uppercase tracking-widest">Term</p>
                        <p class="text-white font-black">{{ $loan->term_months }} <span class="text-[10px] font-medium opacity-60">Months</span></p>
                    </div>
                </div>
            </x-u-i.card>

            <!-- Customer Card -->
            <x-u-i.card>
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center font-black text-slate-400">
                        {{ substr($loan->customer->first_name, 0, 1) }}{{ substr($loan->customer->last_name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-black text-slate-800">{{ $loan->customer->full_name }}</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-tight">Borrower Details</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-slate-50">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">ID Number</span>
                        <span class="text-sm font-bold text-slate-700">{{ $loan->customer->id_number }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-slate-50">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Phone</span>
                        <span class="text-sm font-bold text-slate-700">{{ $loan->customer->phone_number }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">District</span>
                        <span class="text-sm font-bold text-slate-700">{{ $loan->customer->district }}</span>
                    </div>
                </div>
                <x-u-i.button variant="secondary" class="w-full justify-center mt-6" onclick="window.location='{{ route('customers.show', $loan->customer) }}'">
                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                    View Profile
                </x-u-i.button>
            </x-u-i.card>

            <!-- Document Actions -->
            @if($loan->loan_status !== 'pending')
                <x-u-i.card class="bg-slate-50 border-slate-200">
                    <h3 class="font-black text-slate-800 mb-6 flex items-center">
                        <i data-lucide="file-plus" class="w-5 h-5 mr-2 text-indigo-600"></i>
                        {{ __('New Agreement') }}
                    </h3>
                    <form action="{{ route('loans.generate-agreement', $loan) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <select name="template_id" id="template_id" class="w-full px-4 py-3 bg-white border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-100 transition-all">
                                <option value="">Select Template...</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-u-i.button type="submit" class="w-full justify-center">
                            {{ __('Generate Now') }}
                        </x-u-i.button>
                    </form>
                </x-u-i.card>
            @endif
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Repayment Schedule -->
            <x-u-i.card>
                <div class="flex justify-between items-center mb-8">
                    <h3 class="font-black text-xl text-slate-800">{{ __('Repayment Schedule') }}</h3>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Paid</span>
                        <span class="w-3 h-3 bg-amber-500 rounded-full ml-4"></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pending</span>
                    </div>
                </div>

                @if($loan->repaymentSchedules->isEmpty())
                    <div class="py-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="calendar-days" class="w-8 h-8 text-slate-200"></i>
                        </div>
                        <p class="text-slate-400 font-bold text-sm">Schedule will be generated upon approval.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b border-slate-100">
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Due Date') }}</th>
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right">{{ __('Principal') }}</th>
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right">{{ __('Interest') }}</th>
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right">{{ __('Total Due') }}</th>
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-center">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($loan->repaymentSchedules as $schedule)
                                    <tr class="group hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-2">
                                            <span class="text-sm font-bold text-slate-700">{{ $schedule->due_date->format('d M Y') }}</span>
                                        </td>
                                        <td class="py-4 px-2 text-right">
                                            <span class="text-sm font-medium text-slate-600">P{{ number_format($schedule->principal_due, 2) }}</span>
                                        </td>
                                        <td class="py-4 px-2 text-right">
                                            <span class="text-sm font-medium text-slate-600">P{{ number_format($schedule->interest_due, 2) }}</span>
                                        </td>
                                        <td class="py-4 px-2 text-right">
                                            <span class="text-sm font-black text-slate-800">P{{ number_format($schedule->total_due, 2) }}</span>
                                        </td>
                                        <td class="py-4 px-2 text-center">
                                            @if($schedule->status === 'paid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                                    <i data-lucide="check" class="w-3 h-3 mr-1"></i> Paid
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-u-i.card>

            <!-- Document List -->
            <x-u-i.card>
                <h3 class="font-black text-xl text-slate-800 mb-8">{{ __('Generated Documents') }}</h3>
                @if($loan->documents->isEmpty())
                    <div class="py-12 text-center border-2 border-dashed border-slate-100 rounded-3xl">
                        <i data-lucide="file-x" class="w-10 h-10 text-slate-200 mx-auto mb-4"></i>
                        <p class="text-slate-400 font-bold text-sm">No agreements have been generated yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($loan->documents as $document)
                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100 group hover:bg-white hover:shadow-lg hover:shadow-slate-200/50 transition-all">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm border border-slate-100 mr-4">
                                        <i data-lucide="file-text" class="w-6 h-6 text-indigo-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">{{ $document->name }}</p>
                                        <div class="flex items-center mt-1 space-x-3">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                {{ $document->created_at->format('d M Y') }}
                                            </span>
                                            @if($document->signed_at)
                                                <span class="px-2 py-0.5 text-[8px] font-black uppercase bg-emerald-100 text-emerald-700 rounded-lg">Signed</span>
                                            @else
                                                <span class="px-2 py-0.5 text-[8px] font-black uppercase bg-amber-100 text-amber-700 rounded-lg">Pending Signature</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if(!$document->signed_at)
                                        <form action="{{ route('documents.send-for-signature', $document) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Send for Signature">
                                                <i data-lucide="send" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button onclick="window.print()" class="p-2 text-slate-400 hover:bg-slate-100 rounded-xl transition-all" title="Print Agreement">
                                        <i data-lucide="printer" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-u-i.card>
        </div>
    </div>
</x-layouts.app>
