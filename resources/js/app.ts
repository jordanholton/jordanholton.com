import { createInertiaApp } from '@inertiajs/vue3';

createInertiaApp({
    // Each page sets its own full title; fall back to the site name only when none is provided.
    title: (title) => title || 'Jordan Holton',
    progress: {
        color: '#b4f16e',
    },
});
