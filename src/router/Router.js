import Vue from 'vue';
import VueRouter from 'vue-router';
import jump from 'jump.js';
import routes from './Routes';
import store from '../vuex/store';
import Functions from '../imports/Functions';

Vue.use(VueRouter);

// Main Router Instance
const router = new VueRouter({
  routes,
  mode: 'history'
});

// Run before each route change
router.beforeEach((to, from, next) => {

  jump('html', {
    duration: window.pageYOffset > 10 ? 500 : 0,
    callback(){
      new Promise(resolve => {
        store.commit('updatePage', (to.fullPath ? to.fullPath : 'home'));
        resolve();
      }).then(() => {
        /*
         * Check if the URL we're visiting is a preview and then get the appropriate data by a new request.
         * The queryAll endpoint kills the current request if it's a preview
         * */
        if (to.fullPath.indexOf('preview=true') > -1) store.commit('updatePageById', (Functions.getUrlParams().p));
      });

      next();
    }
  });
});


// Run after each route change
// router.afterEach((to, from) => {
// });

export default router;