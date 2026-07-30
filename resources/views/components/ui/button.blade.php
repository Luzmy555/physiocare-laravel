@props(['variant' => 'primary', 'href' => null])
@php
    $variants = [
        'primary' => 'bg-gradient-to-r from-primary to-primary-light text-white shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5',
        'secondary' => 'bg-white text-ink border border-slate-200 hover:bg-slate-50',
        'outline' => 'bg-transparent text-primary border-2 border-primary hover:bg-primary hover:text-white',
        'danger' => 'bg-red-500 text-white hover:bg-red-600 shadow-lg shadow-red-500/20',
        'success' => 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-lg shadow-emerald-500/20',
    ];
    $classes = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 '
        . ($variants[$variant] ?? $variants['primary']);
@endphp
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>{{ $slot }}</button>
@endif
