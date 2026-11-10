@props(['label' => 'Buscar', 'placeholder' => '¿Qué quieres escuchar?'])

<input
    type="search"
    aria-label="{{ $label }}"
    placeholder="{{ $placeholder }}"
    autocomplete="off"
    {{ $attributes->merge(['class' => 'w-full rounded-pill border-2 border-line-strong bg-surface-high px-4 py-3 text-body-sm text-ink placeholder:text-ink-muted']) }}
>
