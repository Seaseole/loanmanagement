<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                    {{ __('Edit Template') }}
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Updating: {{ $template->name }}</p>
            </div>
            <a href="{{ route('templates.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-slate-700 bg-slate-100 px-4 py-2 rounded-xl transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3">
            <x-u-i.card>
                <form action="{{ route('templates.update', $template) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <x-form.input name="name" label="Template Name" required :value="$template->name" />
                    
                    <div class="mb-8">
                        <label for="content" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Agreement Content (HTML/Markdown)</label>
                        <textarea name="content" id="content" rows="20" 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all font-mono text-sm leading-relaxed">{{ $template->content }}</textarea>
                        @error('content')
                            <p class="text-xs text-rose-500 font-bold mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label class="inline-flex items-center group cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }} class="rounded-lg bg-slate-100 border-none text-indigo-600 shadow-sm focus:ring-indigo-100 transition-all cursor-pointer">
                            <span class="ms-3 text-sm font-bold text-slate-600 group-hover:text-slate-800 transition-colors">Mark as Active</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-slate-100">
                        <x-u-i.button>
                            <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                            {{ __('Update Template') }}
                        </x-u-i.button>
                    </div>
                </form>
            </x-u-i.card>
        </div>

        <div class="lg:col-span-1">
            <x-u-i.card class="bg-slate-900 border-none shadow-xl shadow-slate-200 sticky top-28">
                <h3 class="font-black text-xl text-white mb-6 flex items-center">
                    <i data-lucide="tags" class="w-5 h-5 mr-2 text-indigo-400"></i>
                    Merge Tags
                </h3>
                <p class="text-xs text-slate-400 mb-6 leading-relaxed font-medium italic">Click to copy tags and paste them into your template.</p>
                <div class="space-y-3">
                    @foreach($mergeTags as $tag => $description)
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5 hover:border-indigo-500/30 transition-all group cursor-pointer" 
                            onclick="navigator.clipboard.writeText('{{ $tag }}'); alert('Copied: {{ $tag }}')">
                            <code class="text-xs font-black text-indigo-400 block mb-1 group-hover:text-indigo-300">
                                {{ $tag }}
                            </code>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight group-hover:text-slate-300">{{ $description }}</p>
                        </div>
                    @endforeach
                </div>
            </x-u-i.card>
        </div>
    </div>
</x-layouts.app>
