<div>
    <div {{ $attributes->merge(['class' => 'bg-white rounded-[2rem] border border-slate-200/60 shadow-sm overflow-hidden']) }}>
    <div class="p-8">
        {{ $slot }}
    </div>
</div>