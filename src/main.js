/* ===============================
 * This is the main JavaScript file, it hosts all of our imports and also the main Vue instance.
 * =============================== */
// imports
import Vue from 'vue';
import VueLazy from 'vue-lazyload';
import store from './vuex/store';
import App from './App';
import router from './router/Router';
import Ready from './imports/Ready';
import './assets/scss/main.scss';

// Vue Plugins
Vue.use(VueLazy, {
    listenEvents: ['scroll']
});

// Register Global Components this way. They bind to Vue, not the main Vue Instance
Vue.component('app-menu', require('./components/Menus/AppMenu'));
Vue.component('app-menu-item', require('./components/Menus/AppMenuItem'));
Vue.component('container', require('./components/Container/Container'));

// Main vue instance
window.Vue = new Vue({
    el    : '#app',
    store,
    router,
    mounted(){
        new Ready();
    },
    render: h => h(App)
});

