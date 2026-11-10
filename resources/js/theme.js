// Tema claro / oscuro. El valor guardado se aplica en el <head> del layout (antes de pintar);
// aquí solo se maneja el botón y su etiqueta.
const KEY = 'sonora:theme';
const root = document.documentElement;

function updateLabels() {
    const next = root.dataset.theme === 'light' ? 'Usar tema oscuro' : 'Usar tema claro';
    document.querySelectorAll('[data-theme-label]').forEach((el) => {
        el.textContent = next;
    });
}

document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-theme-toggle]')) return;

    const theme = root.dataset.theme === 'light' ? 'dark' : 'light';
    root.dataset.theme = theme;

    try {
        localStorage.setItem(KEY, theme);
    } catch {
        // Sin almacenamiento disponible: el tema solo dura esta página.
    }

    updateLabels();
});

updateLabels();
