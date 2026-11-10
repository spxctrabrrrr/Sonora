{{-- Marca de cinco barras (assets/Logos) + nombre escrito con la tipografía heading. Hereda text-accent, así cambia solo con el tema. --}}
<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'flex items-center gap-2 rounded-md text-heading font-extrabold tracking-tight text-ink']) }}>
    <svg viewBox="0 0 64 64" aria-hidden="true" focusable="false" class="size-7 text-accent">
        <g fill="currentColor">
            <rect x="4" y="32" width="8" height="28" rx="4"/>
            <rect x="16" y="12" width="8" height="48" rx="4"/>
            <rect x="28" y="24" width="8" height="36" rx="4"/>
            <rect x="40" y="4" width="8" height="56" rx="4"/>
            <rect x="52" y="36" width="8" height="24" rx="4"/>
        </g>
    </svg>
    <span>Sonora</span>
</a>
