@props(['label', 'icon', 'variant' => 'default', 'size' => 'md', 'pressed' => null])

{{--
    Botón de solo icono: la etiqueta accesible (label) es obligatoria.
    Área de toque de 40px (md) o 56px (lg) con el icono de 24px centrado.
    Si le pasas contenido, reemplaza al icono (se usa en el botón reproducir/pausar).
--}}
@php
    $sizes = ['md' => 'size-10', 'lg' => 'size-14'];

    $variants = [
        'default' => 'text-ink hover:bg-surface-high',
        'toggle' => 'text-ink-muted hover:bg-surface-high hover:text-ink aria-pressed:bg-surface-high aria-pressed:text-ink aria-pressed:[&_path]:fill-current',
        'primary' => 'bg-accent text-on-accent hover:bg-accent-hover',
        'outline' => 'border-2 border-line-strong text-ink hover:bg-surface-high',
    ];

    $classes = 'grid shrink-0 place-items-center rounded-pill transition '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['default']);
@endphp

<button
    type="button"
    aria-label="{{ $label }}"
    @if (! is_null($pressed)) aria-pressed="{{ $pressed ? 'true' : 'false' }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if ($slot->isEmpty())
        <x-icon :name="$icon" />
    @else
        {{ $slot }}
    @endif
</button>
