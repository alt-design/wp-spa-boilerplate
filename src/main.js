import axios from 'axios'
import Vue from 'vue'
import './assets/scss/main.scss'
import App from './components/App'
import './imports/components'
import Ready from './imports/ready'
import router from './router/router'
import store from './vuex/store'

/**
 * Vue Setup
 */
Vue.prototype.$http = axios.create({
  baseURL: Ready.getSiteURL()
})

/**
 * Main Vue Instance
 */
new Vue({
  el: '#app',
  store,
  router,
  mounted () {
    new Ready()
  },
  render: h => h(App)
})
