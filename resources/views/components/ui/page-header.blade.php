@props(['title', 'subtitle' => null])
<div class="mb-8 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="font-poppins text-2xl font-bold text-ink">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex flex-wrap gap-3">{{ $actions }}</div>
    @endisset
</div>
