import Jump from 'jump.js'
import Vue from 'vue'
import VueRouter from 'vue-router'
import Functions from '../imports/Functions'
import store from '../vuex/store'
import routes from './Routes'

Vue.use(VueRouter)

// Main Router Instance
const router = new VueRouter({
  routes,
  mode: 'history'
})

// Run before each route change
router.beforeEach((to, from, next) => {
  Jump('html', {
    duration: window.pageYOffset > 10 ? 500 : 0,
    callback () {
      new Promise((resolve) => {
        store.commit('updatePost', (to.fullPath ? to.fullPath : 'home'))
        resolve()
      })

      next()
    }
  })
})

// Run after each route change
// router.afterEach((to, from) => {
// });

export default router
