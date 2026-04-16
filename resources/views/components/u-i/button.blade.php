<div>
    @props(['variant' => 'primary'])

@php
    $variants = [
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-100 active:scale-[0.98]',
        'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 active:scale-[0.98]',
        'danger' => 'bg-rose-500 text-white hover:bg-rose-600 shadow-lg shadow-rose-100 active:scale-[0.98]',
        'success' => 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-lg shadow-emerald-100 active:scale-[0.98]',
    ];

    $classes = "inline-flex items-center px-6 py-3 rounded-2xl font-bold text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 " . ($variants[$variant] ?? $variants['primary']);
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
    {{ $slot }}
</button>
</div>