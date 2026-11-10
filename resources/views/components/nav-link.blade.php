@props(['href', 'icon', 'active' => false])

{{-- Enlace de navegación: lateral en escritorio, barra inferior en móvil. La página actual lleva aria-current. --}}
<a
    href="{{ $href }}"
    @if ($active) aria-current="page" @endif
    {{ $attributes->merge(['class' => 'flex flex-1 flex-col items-center gap-1 rounded-md px-2 py-2 text-body-sm font-bold text-ink-muted transition hover:bg-surface-high hover:text-ink aria-[current=page]:bg-surface-high aria-[current=page]:text-ink md:flex-none md:flex-row md:gap-3 md:p-3']) }}
>
    <x-icon :name="$icon" />
    <span>{{ $slot }}</span>
</a>
