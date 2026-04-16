<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Loan Agreements') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Manage legal templates and document structures</p>
            </div>
            @can('create', App\Models\LoanAgreementTemplate::class)
                <x-u-i.button onclick="window.location='{{ route('templates.create') }}'">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    {{ __('New Template') }}
                </x-u-i.button>
            @endcan
        </div>
    </x-slot>

    <x-u-i.card>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-slate-100">
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Template Name') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-center">{{ __('Status') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2">{{ __('Last Updated') }}</th>
                        <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest px-2 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($templates as $template)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="py-6 px-2">
                                <p class="text-sm font-bold text-slate-700">{{ $template->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $template->slug }}</p>
                            </td>
                            <td class="py-6 px-2 text-center">
                                @if($template->is_active)
                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-slate-100 text-slate-500">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-6 px-2">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-600">{{ $template->updated_at->format('d M Y') }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $template->updated_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-2 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @can('update', $template)
                                        <a href="{{ route('templates.edit', $template) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-4">
                                        <i data-lucide="file-text" class="w-10 h-10 text-slate-200"></i>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800">No templates yet</h3>
                                    <p class="text-sm text-slate-400 font-medium mt-1">Start by creating your first loan agreement template.</p>
                                    @can('create', App\Models\LoanAgreementTemplate::class)
                                        <x-u-i.button variant="secondary" class="mt-6" onclick="window.location='{{ route('templates.create') }}'">
                                            Create Template
                                        </x-u-i.button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($templates->hasPages())
            <div class="mt-8 pt-8 border-t border-slate-100">
                {{ $templates->links() }}
            </div>
        @endif
    </x-u-i.card>
</x-layouts.app>
