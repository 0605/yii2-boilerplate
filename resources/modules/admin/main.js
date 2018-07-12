import Vue from 'vue'

import router from './router'
import store from './store'

import App from './App'

import ElementUi from './plugins/ElementUi'
import HttpClient from './plugins/HttpClient'

import '@core/assets/icons/iconfont.less'

import Meta from 'vue-meta'

Vue.use(Meta, { keyName: 'meta' })

Vue.use(ElementUi)

Vue.use(HttpClient, { store, router })

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App),
  beforeCreate() {
    this.$store.commit('INIT_CLIENT_ID')
  }
})
