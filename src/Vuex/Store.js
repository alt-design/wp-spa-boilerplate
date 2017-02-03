import Vue from 'vue'
import VueX from 'vuex'
import state from './State'
import mutations from './Mutations'
import actions from './Actions'
import getters from './Getters'

Vue.use(VueX)

const Store = new VueX.Store({
  state,
  mutations,
  actions,
  getters
})

export default Store
