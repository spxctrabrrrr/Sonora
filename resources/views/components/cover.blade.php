@props(['bars' => []])

{{-- Marcador de portada: barras ecualizadoras sobre surface-high (no hay imágenes ni degradados). --}}
<div {{ $attributes->merge(['class' => 'flex items-end overflow-hidden bg-surface-high transition']) }} aria-hidden="true">
    @foreach ($bars as $height)
        <i class="flex-1 rounded-pill bg-accent" style="height: {{ $height }}%"></i>
    @endforeach
</div>
