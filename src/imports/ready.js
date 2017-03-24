import store from '../vuex/store'

export default class Ready {
  constructor () {
    Ready.setThemeDir()
    Ready.setSiteURL()
    Ready.setName()
    Ready.setAdminURL()
  }

  static setSiteURL () {
    store.commit('setSiteURL', Ready.getSiteURL())
  }

  static setAdminURL () {
    store.commit('setAdminURL', document.getElementById('a-url').innerHTML)
  }

  static getSiteURL () {
    return document.getElementById('url').innerHTML
  }

  static setThemeDir () {
    store.commit('setThemeDir', document.getElementById('theme').innerHTML)
  }

  static setName () {
    store.commit('setName', document.getElementById('name').innerHTML)
  }
}
