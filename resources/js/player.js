// Reproducción simulada: sin audio real. Un temporizador de 1 segundo avanza el tiempo de la pista.
// El estado se guarda en localStorage para que la barra siga igual al cambiar de pantalla.
// La interfaz se marca con atributos data-player-* (ver componentes player-bar, progress y song-row).

const STORAGE_KEY = 'sonora:player';
const data = window.sonora ?? { tracks: [], playlists: {} };
const tracks = new Map(data.tracks.map((track) => [track.id, track]));
const allIds = data.tracks.map((track) => track.id);

if (allIds.length) {
    const defaults = { queue: 'todas', id: allIds[0], time: 0, playing: false, volume: 70, shuffle: false, liked: [] };

    const load = () => {
        try {
            return { ...defaults, ...JSON.parse(localStorage.getItem(STORAGE_KEY)) };
        } catch {
            return { ...defaults };
        }
    };

    const state = load();
    if (!tracks.has(state.id)) Object.assign(state, defaults);

    let timer = null;

    const save = () => {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        } catch {
            // Sin almacenamiento: la simulación sigue, pero no se recuerda entre pantallas.
        }
    };

    const current = () => tracks.get(state.id);
    const queueIds = () => (state.queue === 'todas' ? allIds : (data.playlists[state.queue] ?? allIds));
    const pad = (n) => String(n).padStart(2, '0');
    const format = (seconds) => `${pad(Math.floor(seconds / 60))}:${pad(seconds % 60)}`;
    const percent = () => Math.min(100, (state.time / current().seconds) * 100);
    const setText = (selector, value) => document.querySelectorAll(selector).forEach((el) => (el.textContent = value));

    // ---- Dibujo de la interfaz ----

    function renderProgress() {
        const value = Math.round(percent());

        document.querySelectorAll('[data-player-slider="progress"]').forEach((slider) => {
            slider.setAttribute('aria-valuenow', String(value));
            slider.setAttribute('aria-valuetext', `${format(state.time)} de ${format(current().seconds)}`);
            slider.querySelector('[data-slider-fill]').style.width = `${percent()}%`;
        });

        setText('[data-player-current]', format(state.time));
    }

    function renderVolume() {
        document.querySelectorAll('[data-player-slider="volume"]').forEach((slider) => {
            slider.setAttribute('aria-valuenow', String(state.volume));
            slider.querySelector('[data-slider-fill]').style.width = `${state.volume}%`;
        });
    }

    function renderQueue() {
        const list = document.querySelector('[data-queue-list]');
        const template = document.querySelector('[data-queue-template]');
        if (!list || !template) return;

        list.replaceChildren(
            ...queueIds().map((id, index) => {
                const item = template.content.firstElementChild.cloneNode(true);
                const track = tracks.get(id);
                const row = item.querySelector('button');

                row.dataset.trackId = String(id);
                row.dataset.playerPlay = String(id);
                row.dataset.playerQueue = state.queue;
                row.querySelector('[data-f="number"]').textContent = pad(index + 1);
                row.querySelector('[data-f="title"]').textContent = track.title;
                row.querySelector('[data-f="artist"]').textContent = track.artist;
                row.querySelector('[data-f="duration"]').textContent = track.time;

                return item;
            }),
        );
    }

    function renderTrack() {
        const track = current();

        setText('[data-player-title]', track.title);
        setText('[data-player-artist]', track.artist);
        setText('[data-player-album]', track.album);

        document.querySelectorAll('[data-player-cover]').forEach((cover) => {
            const count = Number(cover.dataset.count) || track.bars.length;

            cover.replaceChildren(
                ...track.bars.slice(0, count).map((height) => {
                    const bar = document.createElement('i');
                    bar.className = 'flex-1 rounded-pill bg-accent';
                    bar.style.height = `${height}%`;
                    return bar;
                }),
            );
        });

        setText('[data-player-total]', format(track.seconds));
        renderQueue();

        document.querySelectorAll('[data-track-id]').forEach((row) => {
            row.setAttribute('aria-current', Number(row.dataset.trackId) === state.id ? 'true' : 'false');
        });

        renderControls();
        renderProgress();
    }

    function renderControls() {
        document.querySelectorAll('[data-player-toggle]').forEach((button) => {
            button.setAttribute('aria-label', state.playing ? 'Pausar' : 'Reproducir');
            button.querySelector('[data-icon="play"]')?.classList.toggle('hidden', state.playing);
            button.querySelector('[data-icon="pause"]')?.classList.toggle('hidden', !state.playing);
        });

        document.querySelectorAll('[data-player-shuffle]').forEach((button) => {
            button.setAttribute('aria-pressed', String(state.shuffle));
        });

        document.querySelectorAll('[data-player-like]').forEach((button) => {
            button.setAttribute('aria-pressed', String(state.liked.includes(state.id)));
        });
    }

    // ---- Acciones ----

    function sync() {
        clearInterval(timer);
        timer = state.playing ? setInterval(tick, 1000) : null;
    }

    function commit() {
        renderTrack();
        sync();
        save();
    }

    function tick() {
        state.time += 1;

        if (state.time >= current().seconds) {
            step(1);
            return;
        }

        renderProgress();
        save();
    }

    function play(id, queue) {
        state.queue = queue;
        state.id = id;
        state.time = 0;
        state.playing = true;
        commit();
    }

    function step(direction) {
        const ids = queueIds();
        let index = ids.indexOf(state.id);

        if (direction < 0 && state.time > 3) {
            state.time = 0; // Anterior: primero reinicia la pista si ya avanzó
            commit();
            return;
        }

        if (state.shuffle && ids.length > 1) {
            let next = index;
            while (next === index) next = Math.floor(Math.random() * ids.length);
            index = next;
        } else {
            index = (index + direction + ids.length) % ids.length;
        }

        state.id = ids[index];
        state.time = 0;
        commit();
    }

    function seek(percentValue) {
        state.time = Math.round((percentValue / 100) * current().seconds);
        renderProgress();
        save();
    }

    function setVolume(value) {
        state.volume = Math.max(0, Math.min(100, value));
        renderVolume();
        save();
    }

    // ---- Eventos ----

    document.addEventListener('click', (event) => {
        const target = event.target.closest(
            '[data-player-play], [data-player-start], [data-player-toggle], [data-player-next], [data-player-prev], [data-player-shuffle], [data-player-like]',
        );
        if (!target) return;

        if (target.matches('[data-player-play]')) {
            play(Number(target.dataset.playerPlay), target.dataset.playerQueue || 'todas');
        } else if (target.matches('[data-player-start]')) {
            const slug = target.dataset.playerStart;
            play(data.playlists[slug][0], slug);
        } else if (target.matches('[data-player-toggle]')) {
            state.playing = !state.playing;
            commit();
        } else if (target.matches('[data-player-next]')) {
            step(1);
        } else if (target.matches('[data-player-prev]')) {
            step(-1);
        } else if (target.matches('[data-player-shuffle]')) {
            state.shuffle = !state.shuffle;
            renderControls();
            save();
        } else if (target.matches('[data-player-like]')) {
            state.liked = state.liked.includes(state.id) ? state.liked.filter((id) => id !== state.id) : [...state.liked, state.id];
            renderControls();
            save();
        }
    });

    // Barras de progreso y volumen: clic, arrastre y teclado
    let dragging = null;

    const fromPointer = (slider, event) => {
        const rect = slider.getBoundingClientRect();
        const value = Math.max(0, Math.min(100, ((event.clientX - rect.left) / rect.width) * 100));
        slider.dataset.playerSlider === 'volume' ? setVolume(Math.round(value)) : seek(value);
    };

    document.addEventListener('pointerdown', (event) => {
        const slider = event.target.closest('[data-player-slider]');
        if (!slider) return;
        dragging = slider;
        slider.setPointerCapture?.(event.pointerId);
        fromPointer(slider, event);
    });

    document.addEventListener('pointermove', (event) => {
        if (dragging) fromPointer(dragging, event);
    });

    ['pointerup', 'pointercancel'].forEach((name) => document.addEventListener(name, () => (dragging = null)));

    document.addEventListener('keydown', (event) => {
        const slider = event.target.closest?.('[data-player-slider]');
        if (!slider) return;

        const isVolume = slider.dataset.playerSlider === 'volume';
        const duration = current().seconds;
        const keys = {
            ArrowRight: 5,
            ArrowUp: 5,
            ArrowLeft: -5,
            ArrowDown: -5,
            PageUp: isVolume ? 10 : 30,
            PageDown: isVolume ? -10 : -30,
        };

        if (event.key === 'Home' || event.key === 'End') {
            event.preventDefault();
            const toStart = event.key === 'Home';
            isVolume ? setVolume(toStart ? 0 : 100) : seek(toStart ? 0 : 100);
            return;
        }

        if (!(event.key in keys)) return;
        event.preventDefault();

        if (isVolume) {
            setVolume(state.volume + keys[event.key]);
        } else {
            state.time = Math.max(0, Math.min(duration - 1, state.time + keys[event.key]));
            renderProgress();
            save();
        }
    });

    window.addEventListener('pagehide', save);

    // ---- Inicio ----
    renderVolume();
    renderTrack();
    sync();
}
