// Buscar: filtra en el navegador las playlists y canciones ya renderizadas.
const input = document.querySelector('[data-search-input]');

if (input) {
    const items = document.querySelectorAll('[data-search-item]');
    const sections = document.querySelectorAll('[data-search-section]');
    const count = document.querySelector('[data-search-count]');
    const empty = document.querySelector('[data-search-empty]');

    const normalize = (text) =>
        text
            .toLowerCase()
            .normalize('NFD')
            .replace(/\p{M}/gu, '')
            .trim();

    const run = () => {
        const query = normalize(input.value);
        let visible = 0;

        items.forEach((item) => {
            const match = query === '' || item.dataset.searchText.includes(query);
            item.hidden = !match;
            if (match) visible++;
        });

        sections.forEach((section) => {
            section.hidden = ![...section.querySelectorAll('[data-search-item]')].some((item) => !item.hidden);
        });

        empty.hidden = visible > 0;
        count.textContent = query === '' ? '' : `${visible} ${visible === 1 ? 'resultado' : 'resultados'}`;
    };

    input.addEventListener('input', run);
    input.form?.addEventListener('submit', (event) => event.preventDefault());
}
