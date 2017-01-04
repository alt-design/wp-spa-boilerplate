import store from '../vuex/store';

export default class Ready {

    constructor() {
        Ready.setThemeDir();
        Ready.setSiteURL();
        Ready.setName();
    }

    static setSiteURL() {
        store.commit('setSiteURL', Ready.getSiteURL())
    }

    static getSiteURL() {
        let url = document.querySelector('#url').innerHTML;
        return url[url.length - 1] === '/' ? url.slice(0, -1) : url
    }

    static setThemeDir() {
        store.commit('setThemeDir', document.querySelector('#theme').innerHTML)
    }

    static setName() {
        store.commit('setName', document.querySelector('#name').innerHTML)
    }
}