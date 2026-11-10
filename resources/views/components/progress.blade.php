@props(['kind' => 'progress', 'label' => 'Progreso', 'value' => 0, 'withTimes' => true])

{{--
    Barra de progreso (o de volumen) con role="slider" y teclado con flechas.
    El JS del reproductor actualiza aria-valuenow, el relleno y los tiempos.
--}}
<div {{ $attributes->merge(['class' => 'flex items-center gap-2 font-mono text-mono-sm text-ink-muted']) }}>
    @if ($withTimes)
        <span data-player-current>00:00</span>
    @endif
    <div
        role="slider"
        tabindex="0"
        aria-label="{{ $label }}"
        aria-valuemin="0"
        aria-valuemax="100"
        aria-valuenow="{{ $value }}"
        data-player-slider="{{ $kind }}"
        class="flex h-6 flex-1 cursor-pointer items-center rounded-pill"
    >
        <div class="h-1 w-full rounded-pill bg-surface-high">
            <div data-slider-fill class="h-1 rounded-pill bg-accent" style="width: {{ $value }}%"></div>
        </div>
    </div>
    @if ($withTimes)
        <span data-player-total>00:00</span>
    @endif
</div>
