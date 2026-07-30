@props(['label' => null, 'name', 'required' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-ink">
            {{ $label }}{{ $required ? ' *' : '' }}
        </label>
    @endif
    <input
        {{ $attributes->merge([
            'id' => $name,
            'name' => $name,
            'class' => 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm transition focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/10 disabled:bg-slate-50 disabled:text-slate-400',
        ]) }}
    />
    @error($name)
        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
