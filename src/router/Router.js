import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './Routes';
import store from '../vuex/store';
import jump from 'jump.js';

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
            store.commit('updatePage', (to.path ? to.path : 'home'));
            next();
        }
    });
});

// Run after each route change
// router.afterEach((to, from) => {
// });

export default router