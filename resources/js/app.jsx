import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { initializeTheme } from './hooks/use-appearance';
import { useEffect } from 'react';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.jsx`, import.meta.glob('./pages/**/*.jsx')),
    setup({ el, App, props }) {

        // for toast
        const MainApp = () => {
            const { toast: flashToast } = props.initialPage.props;

            useEffect(() => {
                if(flashToast) {
                    const { type, message } = flashToast;

                    if (type === 'success') toast.success(message);
                    else if (type === 'error') toast.error(message);
                    else if (type === 'warning') toast.warning(message);
                    else toast(message);
                }
            }, [flashToast]);

            return (
                <>
                    <Toaster position="top-right" richColors />
                    <App {...props} />
                </>
            );
        };

        const root = createRoot(el);
        root.render(<MainApp />);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on load...
initializeTheme();
