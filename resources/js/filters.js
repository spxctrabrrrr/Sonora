// Chips de filtro de Inicio: un solo chip presionado por grupo; muestran u ocultan secciones.
document.querySelectorAll('[data-chip-group]').forEach((group) => {
    const chips = group.querySelectorAll('[data-filter]');

    group.addEventListener('click', (event) => {
        const chip = event.target.closest('[data-filter]');
        if (!chip) return;

        chips.forEach((other) => other.setAttribute('aria-pressed', String(other === chip)));

        const filter = chip.dataset.filter;
        document.querySelectorAll('[data-section]').forEach((section) => {
            section.hidden = filter !== 'todo' && section.dataset.section !== filter;
        });
    });
});
