<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Create Loan Application') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Originate a new credit facility for a registered borrower</p>
            </div>
            <a href="{{ route('loans.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-slate-700 bg-slate-100 px-4 py-2 rounded-xl transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-u-i.card>
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf

                <div class="mb-8">
                    <label for="customer_id" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Select Borrower</label>
                    <div class="relative">
                        <select name="customer_id" id="customer_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all font-bold appearance-none">
                            <option value="">Choose a customer...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->full_name }} ({{ $customer->id_number }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                        </div>
                    </div>
                    @error('customer_id')
                        <p class="text-xs text-rose-500 font-bold mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                    <x-form.input name="principal_amount" label="Principal Amount (BWP)" type="number" step="0.01" required placeholder="e.g. 10000.00" />
                    <x-form.input name="interest_rate" label="Annual Interest Rate (%)" type="number" step="0.01" required placeholder="e.g. 15.5" />
                    <x-form.input name="term_months" label="Loan Term (Months)" type="number" required placeholder="e.g. 12" />
                </div>

                <div class="flex items-center justify-between pt-10 mt-6 border-t border-slate-100">
                    <div class="hidden md:flex items-center text-slate-400">
                        <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i>
                        <span class="text-xs font-medium tracking-tight">Terms and conditions will be generated automatically</span>
                    </div>
                    <x-u-i.button>
                        <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                        {{ __('Create Application') }}
                    </x-u-i.button>
                </div>
            </form>
        </x-u-i.card>
    </div>
</x-layouts.app>
