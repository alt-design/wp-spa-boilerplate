import store from '../vuex/store';

export default class Functions {

  static updateAdminBar() {

    let editPage = document.getElementById('wp-admin-bar-edit').querySelector('a');
    if (editPage) editPage.setAttribute('href', store.state.adminUrl + '/post.php?post=' + store.state.page.ID + '&action=edit');

  }

  static getUrlParams() {
    let queryString = window.location.href.split('?')[1];
    if (queryString) {
      let keyValuePairs = queryString.split('&');
      let keyValue, params = {};

      keyValuePairs.forEach(pair => {
        keyValue = pair.split('=');
        params[keyValue[0]] = decodeURIComponent(keyValue[1]).replace('+', ' ');
      });

      return params;
    }
    return false;
  }

};