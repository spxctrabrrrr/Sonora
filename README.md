# Sonora

Frontend de una app de música (solo vistas, sin backend) construido con Laravel 13, Blade y Tailwind CSS v4 siguiendo el sistema de diseño de Sonora. La reproducción es simulada: no hay audio real.

## Cómo ejecutarlo

Requisitos: PHP 8.3 o superior, Composer, Node.js y Laravel Herd.

```bash
composer install
npm install
copy .env.example .env      # en Mac: cp .env.example .env
php artisan key:generate
npm run dev
```

Con el proyecto dentro de la carpeta de Herd, ábrelo en `http://sonora.test`. Si prefieres no usar Herd: `php artisan serve` en otra terminal y abre `http://localhost:8000`.

Para compilar sin servidor de desarrollo: `npm run build`.

## Pantallas

| Ruta | Pantalla | Alcance |
| --- | --- | --- |
| `/` | Inicio | Obligatoria |
| `/playlists/{slug}` | Playlist | Obligatoria |
| `/reproductor` | Reproductor | Obligatoria |
| `/buscar` | Buscar | Extra |
| `/biblioteca` | Tu biblioteca | Apoyo a la navegación |

También incluye tema claro (botón en la navegación, se recuerda entre visitas) y versión móvil de 390px (la navegación pasa a una barra inferior).

## Estructura

- `resources/css/app.css`: tokens del sistema (colores por tema, tipografía, radios, sombra) conectados a Tailwind con `@theme`. Es el único archivo con valores hexadecimales.
- `resources/views/components/`: componentes Blade reutilizables (`button`, `icon-button`, `chip`, `media-card`, `song-row`, `progress`, `search-field`, `cover`, `icon`, `logo`, `nav-link`, `player-bar`) y el layout `layouts/app`.
- `resources/views/*.blade.php`: las cinco pantallas.
- `app/Support/Catalog.php`: datos de ejemplo inventados (12 canciones y 4 playlists).
- `app/Http/Controllers/`: un controlador de una sola acción por pantalla.
- `resources/js/player.js`: reproducción simulada (temporizador de 1 segundo). El estado se guarda en `localStorage` para que la barra no se reinicie al cambiar de pantalla.

## Accesibilidad

- Anillo de enfoque de 3px en `focus` con 2px de separación en todo elemento interactivo.
- Toda la interfaz se usa con teclado; los controles de progreso y volumen son `role="slider"` con flechas, Re Pág, Av Pág, Inicio y Fin.
- Los botones de solo icono llevan `aria-label` obligatorio (componente `icon-button`).
- La pista actual se marca con `aria-current`, la navegación con `aria-current="page"` y los filtros con `aria-pressed`.
- Enlace "Saltar al contenido" y respeto de `prefers-reduced-motion`.

## Decisiones

- **Componentes anónimos de Blade** en lugar de clases PHP: no hay lógica de servidor que justifique una clase por componente, y las recetas de Tailwind quedan visibles en cada archivo.
- **Datos en una clase PHP** (`Catalog`) en lugar de base de datos: el alcance es solo frontend. Pasar a modelos solo cambia el origen de los métodos.
- **Un solo botón primario por vista:** en Playlist el botón "Reproducir" es el primario y el de la barra inferior pasa a estilo contorno; en el Reproductor no hay barra inferior.
- **Fuentes por Google Fonts** con `<link>` en el layout, como indica Tailwind.md, sin tocar `vite.config.js`.
- **Reutilicé** `Button`, `Chip`, `MediaCard`, `SongRow`, `Progress` y `SearchField` del sistema; `icon-button`, `cover` y `player-bar` son piezas derivadas para cubrir los íconos, las portadas de marcador y la barra del reproductor.


