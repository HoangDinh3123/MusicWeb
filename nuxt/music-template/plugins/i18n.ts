import { createI18n } from 'vue-i18n'
import { locale as vn } from '~/locales/index'
let messages = {}
// console.log(vn, 'vn')
messages = { ...messages, vn }
// get current selected language
const lang = 'vn'
export default defineNuxtPlugin(({ vueApp }) => {
  const i18n = createI18n({
    legacy: false,
    globalInjection: true,
    locale: lang,
    messages
  })
  vueApp.use(i18n)
  return {
    provide: { i18n },
    global: {}
  }
})