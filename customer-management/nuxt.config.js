export default {
    // Global page headers: https://go.nuxtjs.dev/config-head
    ssr: false,
    head: {
        title: 'customer-management',
        htmlAttrs: {
            lang: 'en'
        },
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            { hid: 'description', name: 'description', content: '' }
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
        ]
    },

    // Global CSS: https://go.nuxtjs.dev/config-css
    css: [],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [],

    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [],
    // Modules: https://go.nuxtjs.dev/config-modules
    modules: [
        // https://go.nuxtjs.dev/bootstrap
        'bootstrap-vue/nuxt', '@nuxtjs/axios', '@nuxtjs/auth',
        //OR like this
        ['@nuxtjs/fontawesome', {
            component: 'fa',
            imports: [
                //import whole set
                {
                    set: '@fortawesome/free-solid-svg-icons',
                    icons: ['fas']
                },
                //import 2 icons from set
                // please note this is PRO set in this example,
                // you must have it in your node_modules to actually import
            ]
        }],
    ],
    fontawesome: {
        imports: [{
            set: '@fortawesome/free-solid-svg-icons',
            icons: ['fas']
        }, ],
        component: 'fa'
    },

    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {},

    axios: {
        // proxy: true
        baseURL: 'http://127.0.0.1:8000/api/',
        proxyHeaders: false,
        credentials: false
    },

    auth: {
        redirect: {
            callback: '/'
        },
        strategies: {
            local: {
                endpoints: {
                    // các đường dẫn đến API
                    login: { url: 'login', method: 'post' },
                    // sau khi login, sẽ tự động chạy cái API này nữa để lấy dữ liệu user
                    user: { url: 'user', method: 'get' },
                    logout: false
                }
            },
        }
    },
    router: {
        middleware: ['auth']
    },
}