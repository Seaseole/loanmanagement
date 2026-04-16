<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ $customer->full_name }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Customer Profile & Loan History</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('customers.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-slate-700 bg-slate-100 px-4 py-2 rounded-xl transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    {{ __('Back to List') }}
                </a>
                <x-u-i.button variant="secondary">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    Edit Profile
                </x-u-i.button>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Contact Info -->
            <x-u-i.card>
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-16 h-16 bg-indigo-600 rounded-[1.5rem] flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-indigo-200">
                        {{ substr($customer->first_name, 0, 1) }}{{ substr($customer->last_name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-black text-xl text-slate-800 leading-none">{{ $customer->full_name }}</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-2">Verified Customer</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mr-4 border border-slate-100">
                            <i data-lucide="mail" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email Address</p>
                            <p class="text-sm font-bold text-slate-700">{{ $customer->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mr-4 border border-slate-100">
                            <i data-lucide="phone" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Phone Number</p>
                            <p class="text-sm font-bold text-slate-700">{{ $customer->phone_number }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mr-4 border border-slate-100">
                            <i data-lucide="fingerprint" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID Number (Omang)</p>
                            <p class="text-sm font-bold text-slate-700">{{ $customer->id_number }}</p>
                        </div>
                    </div>
                </div>
            </x-u-i.card>

            <!-- Address Info -->
            <x-u-i.card class="bg-slate-50 border-slate-200">
                <h3 class="font-black text-slate-800 mb-6 flex items-center">
                    <i data-lucide="map-pin" class="w-5 h-5 mr-2 text-indigo-600"></i>
                    Location Details
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">District</p>
                        <p class="text-sm font-bold text-slate-700">{{ $customer->district }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">City / Town</p>
                        <p class="text-sm font-bold text-slate-700">{{ $customer->city_town }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Physical Address</p>
                        <p class="text-sm font-bold text-slate-600 leading-relaxed">{{ $customer->physical_address }}</p>
                    </div>
                </div>
            </x-u-i.card>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Loan History -->
            <x-u-i.card>
                <div class="flex justify-between items-center mb-8">
                    <h3 class="font-black text-xl text-slate-800">{{ __('Loan History') }}</h3>
                    <x-u-i.button variant="secondary" onclick="window.location='{{ route('loans.create', ['customer_id' => $customer->id]) }}'">
                        <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                        New Loan
                    </x-u-i.button>
                </div>

                @if($customer->loans->isEmpty())
                    <div class="py-20 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="banknote" class="w-10 h-10 text-slate-200"></i>
                        </div>
                        <h4 class="text-lg font-black text-slate-800">No active loans</h4>
                        <p class="text-sm text-slate-400 font-medium mt-1">This customer hasn't applied for any loans yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b border-slate-100">
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Date') }}</th>
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right">{{ __('Amount') }}</th>
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-center">{{ __('Status') }}</th>
                                    <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($customer->loans as $loan)
                                    <tr class="group hover:bg-slate-50/50 transition-colors">
                                        <td class="py-6 px-2">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-slate-700">{{ $loan->created_at->format('d M Y') }}</span>
                                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Applied</span>
                                            </div>
                                        </td>
                                        <td class="py-6 px-2 text-right">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-black text-slate-800">P{{ number_format($loan->principal_amount, 2) }}</span>
                                                <span class="text-[10px] text-slate-400 font-bold tracking-tight">{{ $loan->term_months }} Months</span>
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
                                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-u-i.card>
        </div>
    </div>
</x-layouts.app>
