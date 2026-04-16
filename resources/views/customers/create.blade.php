<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Onboard New Customer') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Register a new borrower in the system</p>
            </div>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-slate-700 bg-slate-100 px-4 py-2 rounded-xl transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-u-i.card>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                    <x-form.input name="first_name" label="First Name" required placeholder="e.g. Eugene" />
                    <x-form.input name="last_name" label="Last Name" required placeholder="e.g. Smith" />
                    <x-form.input name="id_number" label="ID Number (Omang)" required placeholder="9 digits" />
                    <x-form.input name="phone_number" label="Phone Number" required placeholder="+267..." />
                    <x-form.input name="email" label="Email Address" type="email" placeholder="customer@example.com" />
                    
                    <div class="mb-6">
                        <label for="district" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">District</label>
                        <select name="district" id="district" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all font-medium">
                            <option value="">Select District</option>
                            @foreach($districts as $district)
                                <option value="{{ $district }}">{{ $district }}</option>
                            @endforeach
                        </select>
                        @error('district')
                            <p class="text-xs text-rose-500 font-bold mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form.input name="city_town" label="City / Town" required placeholder="e.g. Gaborone" />
                </div>

                <div class="mb-8">
                    <label for="physical_address" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Physical Address</label>
                    <textarea name="physical_address" id="physical_address" rows="3" 
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all font-medium placeholder:text-slate-300"
                        placeholder="Plot number, Street name..."></textarea>
                    @error('physical_address')
                        <p class="text-xs text-rose-500 font-bold mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end pt-6 border-t border-slate-100">
                    <x-u-i.button>
                        <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                        {{ __('Complete Onboarding') }}
                    </x-u-i.button>
                </div>
            </form>
        </x-u-i.card>
    </div>
</x-layouts.app>
