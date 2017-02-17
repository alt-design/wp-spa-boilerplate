import Vue from 'vue'

export default RegisterComponents = () => {
  Vue.component('page-builder', require('../Components/PageBuilder'))
  Vue.component('app-header', require('../Components/Header'))
  Vue.component('app-footer', require('../Components/Footer'))
  Vue.component('breadcrumbs', require('../Components/Breadcrumbs'))
  Vue.component('app-menu', require('../Components/Menus/AppMenu'))
  Vue.component('app-menu-item', require('../Components/Menus/AppMenuItem'))
}
