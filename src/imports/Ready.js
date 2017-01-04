import store from "../vuex/store";

export default class Ready {

    constructor() {
        Ready.setThemeDir();
        Ready.setSiteURL();
        Ready.setTagLine();
        Ready.setName();
    }

    static setSiteURL() {
        store.commit('setSiteURL', document.querySelector('#url').innerHTML)
    }

    static setThemeDir() {
        store.commit('setThemeDir', document.querySelector('#theme').innerHTML)
    }

    static setTagLine() {
        store.commit('setTagLine', document.querySelector('#tagLine').innerHTML)
    }

    static setName() {
        store.commit('setName', document.querySelector('#name').innerHTML)
    }
}