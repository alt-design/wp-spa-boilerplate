import Store from '../Vuex/Store'

export default class Ready {

  constructor () {
    Ready.setThemeDir()
    Ready.setSiteURL()
    Ready.setName()
    Ready.setAdminURL()
  }

  static setSiteURL () {
    Store.commit('setSiteURL', Ready.getSiteURL())
  }

  static setAdminURL () {
    Store.commit('setAdminURL', document.getElementById('a-url').innerHTML)
  }

  static getSiteURL () {
    return document.getElementById('url').innerHTML
  }

  static setThemeDir () {
    Store.commit('setThemeDir', document.getElementById('theme').innerHTML)
  }

  static setName () {
    Store.commit('setName', document.getElementById('name').innerHTML)
  }
}
