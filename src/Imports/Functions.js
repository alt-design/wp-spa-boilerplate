import Store from '../Vuex/Store'

export default class Functions {

  static updateAdminBar () {
    const editPage = document.getElementById('wp-admin-bar-edit')
    const editPageLink = editPage ? editPage.querySelector('a') : false
    editPageLink && editPage.setAttribute('href', `${Store.state.adminUrl}/post.php?post=${Store.state.post.ID}&action=edit`)
  }

  static getUrlParams () {
    const queryString = window.location.href.split('?')[1]
    if (queryString) {
      const keyValuePairs = queryString.split('&')
      const params = {}
      let keyValue

      keyValuePairs.forEach((pair) => {
        keyValue = pair.split('=')
        params[keyValue[0]] = decodeURIComponent(keyValue[1]).replace('+', ' ')
      })

      return params
    }
    return false
  }
}
