@props(['icon' => 'fa-inbox', 'title', 'text' => null])
<div class="flex flex-col items-center justify-center py-16 text-center">
    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-2xl text-slate-400">
        <i class="fa-solid {{ $icon }}"></i>
    </div>
    <p class="text-base font-semibold text-ink">{{ $title }}</p>
    @if($text)
        <p class="mt-1 text-sm text-slate-500">{{ $text }}</p>
    @endif
    @if(trim($slot))
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
