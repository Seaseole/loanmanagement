<@props(['disabled' => false, 'label' => '', 'name' => '', 'type' => 'text'])

<div class="mb-6">
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">
            {{ $label }}
        </label>
    @endif

    <input {{ $disabled ? 'disabled' : '' }} 
        type="{{ $type }}"
        {!! $attributes->merge(['class' => 'w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-300 font-medium']) !!} 
        id="{{ $name }}" 
        name="{{ $name }}">

    @error($name)
        <p class="text-xs text-rose-500 font-bold mt-2 ml-1">{{ $message }}</p>
    @enderror
</div>