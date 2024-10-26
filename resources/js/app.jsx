import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./React/Pages/${name}.jsx`,
            import.meta.glob('./React/Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(document.querySelector('.app'));

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});
