<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Customers') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Manage your borrower directory</p>
            </div>
            @can('create', App\Models\Customer::class)
                <x-u-i.button onclick="window.location='{{ route('customers.create') }}'">
                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                    {{ __('Onboard Customer') }}
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
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('ID Number') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Location') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customers as $customer)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center mr-3 font-black text-slate-400 text-xs group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                        {{ substr($customer->first_name, 0, 1) }}{{ substr($customer->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">{{ $customer->full_name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $customer->phone_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <span class="text-sm font-bold text-slate-600">{{ $customer->id_number }}</span>
                            </td>
                            <td class="py-4 px-2">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-600">{{ $customer->city_town }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">{{ $customer->district }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-right">
                                <a href="{{ route('customers.show', $customer) }}" class="p-2 text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all inline-block">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-4">
                                        <i data-lucide="users" class="w-10 h-10 text-slate-200"></i>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800">No customers yet</h3>
                                    <p class="text-sm text-slate-400 font-medium mt-1">Start by onboarding your first borrower.</p>
                                    @can('create', App\Models\Customer::class)
                                        <x-u-i.button variant="secondary" class="mt-6" onclick="window.location='{{ route('customers.create') }}'">
                                            Onboard Customer
                                        </x-u-i.button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($customers->hasPages())
            <div class="mt-8 pt-8 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        @endif
    </x-u-i.card>
</x-layouts.app>
