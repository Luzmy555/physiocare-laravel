<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            {{ $slot }}
        </table>
    </div>
</div>
