import store from '../vuex/store'
import axios from 'axios'

export default class Ready {
  constructor () {
    Ready.setGlobalOptions()
    Ready.setThemeDir()
    Ready.setSiteURL()
    Ready.setName()
    Ready.setAdminURL()
  }

  static setGlobalOptions () {
    axios.get(`${Ready.getSiteURL()}/wp-json/alt/v1/global-acf`).then(res => {
      store.commit('setGlobalOptions', res.data)
    })
  }

  static setAdminURL () {
    store.commit('setAdminURL', document.getElementById('a-url').innerHTML)
  }

  static setSiteURL () {
    store.commit('setSiteURL', Ready.getSiteURL())
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
