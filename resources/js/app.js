import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from 'ziggy-js'
import { formatDate, timeAgo } from './utils/date'
import '../css/app.css'

createInertiaApp({
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')
    ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)

        app.config.globalProperties.$formatDate = formatDate
        app.config.globalProperties.$timeAgo = timeAgo

        app.mount(el)
    },
    progress: {
        color: '#3B82F6',
    },
})
