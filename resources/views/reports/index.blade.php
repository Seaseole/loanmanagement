<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Reports Center') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Generate and export regulatory documentation</p>
            </div>
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center">
                <i data-lucide="bar-chart-big" class="w-6 h-6 text-indigo-600"></i>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Regulatory Report -->
        <x-u-i.card class="relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-[4rem] -mr-12 -mt-12 group-hover:scale-110 transition-transform duration-500"></div>
            
            <div class="relative z-10">
                <div class="w-14 h-14 bg-indigo-100 rounded-[1.25rem] flex items-center justify-center mb-6 shadow-inner shadow-indigo-200/50">
                    <i data-lucide="shield-check" class="w-7 h-7 text-indigo-600"></i>
                </div>
                
                <h3 class="text-xl font-black text-slate-800 mb-2">Regulatory Report</h3>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
                    Bank of Botswana compliant reporting. Includes all disbursed loans, borrower Omang numbers, and outstanding balances.
                </p>
                
                <form action="{{ route('reports.regulatory') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <x-form.input name="start_date" label="Start Date" type="date" required />
                        <x-form.input name="end_date" label="End Date" type="date" required />
                    </div>
                    
                    <div class="flex items-center space-x-3 pt-2">
                        <x-u-i.button type="submit" class="flex-grow justify-center">
                            <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                            View Report
                        </x-u-i.button>
                        <x-u-i.button type="submit" name="export" value="1" variant="secondary">
                            <i data-lucide="download" class="w-4 h-4"></i>
                        </x-u-i.button>
                    </div>
                </form>
            </div>
        </x-u-i.card>

        <!-- Portfolio Performance -->
        <x-u-i.card class="bg-slate-50 border-slate-200/60 flex flex-col justify-center items-center text-center py-12">
            <div class="w-20 h-20 bg-white rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100 shadow-sm text-slate-200">
                <i data-lucide="line-chart" class="w-10 h-10"></i>
            </div>
            <h3 class="text-xl font-black text-slate-400 mb-2">Analytics & Trends</h3>
            <p class="text-sm text-slate-400 font-medium max-w-[240px]">
                Advanced data visualization and delinquency forecasting is currently in development.
            </p>
            <div class="mt-8 px-4 py-2 bg-white rounded-xl border border-slate-200 text-[10px] font-black uppercase tracking-widest text-slate-400">
                Coming in v2.0
            </div>
        </x-u-i.card>
    </div>
</x-layouts.app>
