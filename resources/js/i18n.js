import { createI18n }   from 'vue-i18n'
import en from './locales/en.json'

export const i18n = createI18n ({
  locale: process.env.MIX_VUE_APP_I18N_LOCALE || 'en',
  fallbackLocale: process.env.MIX_VUE_APP_I18N_FALLBACK_LOCALE || 'en',
  globalInjection: true,
  messages: { en }

})
