@props(['label' => null, 'name', 'required' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-ink">
            {{ $label }}{{ $required ? ' *' : '' }}
        </label>
    @endif
    <textarea
        {{ $attributes->merge([
            'id' => $name,
            'name' => $name,
            'rows' => 4,
            'class' => 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm transition focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/10',
        ]) }}
    >{{ $slot }}</textarea>
    @error($name)
        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
