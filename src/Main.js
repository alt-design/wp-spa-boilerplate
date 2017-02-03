/* ===============================
 * This is the main JavaScript file, it hosts all of our imports and also the main Vue instance.
 * =============================== */
// imports
import Vue from 'vue'
import VueLazy from 'vue-lazyload'
import axios from 'axios'
import store from './Vuex/Store'
import router from './Router/Router'
import Ready from './Imports/Ready'
import App from './App'
import AppMenu from './Components/Menus/AppMenu'
import AppMenuItem from './Components/Menus/AppMenuItem'

import './Assets/SCSS/main.scss'

// Vue Plugins
Vue.use(VueLazy)

Vue.prototype.$http = axios.create({
  baseURL: Ready.getSiteURL()
})

// Register Global Components this way. They bind to Vue, not the main Vue Instance
Vue.component('app-menu', AppMenu)
Vue.component('app-menu-item', AppMenuItem)

// Main vue instance
new Vue({
  el: '#app',
  store,
  router,
  mounted () {
    new Ready()
  },
  render: h => h(App)
})

