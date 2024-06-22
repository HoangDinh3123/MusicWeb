// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: false },
  modules: [
    'nuxt-icon', 
    'nuxt-swiper', 
    '@pinia/nuxt',
  ],
  css: ['~/assets/css/main.css'],
  plugins: [
    { src: '~/plugins/pusher.client.js', mode: 'client' }
  ],
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
})