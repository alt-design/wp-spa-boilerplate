import store from '../vuex/store';

export default class Functions {

    static updateAdminBar() {

        let editPage = document.getElementById('wp-admin-bar-edit').querySelector('a');
        if (editPage) editPage.setAttribute('href', store.state.adminUrl + '/post.php?post=' + store.state.page.ID + '&action=edit')

    }

}