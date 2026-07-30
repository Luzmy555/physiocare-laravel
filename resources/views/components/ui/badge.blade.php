@props(['color' => 'slate'])
@php
    $map = [
        'amber' => 'bg-amber-100 text-amber-700',
        'green' => 'bg-emerald-100 text-emerald-700',
        'red' => 'bg-red-100 text-red-700',
        'blue' => 'bg-blue-100 text-blue-700',
        'slate' => 'bg-slate-100 text-slate-600',
    ];
@endphp
<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide ' . ($map[$color] ?? $map['slate'])]) }}>
    {{ $slot }}
</span>
