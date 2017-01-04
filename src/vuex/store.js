import Vue from "vue";
import VueX from "vuex";
import State from "./state";
import Mutations from "./mutations";
import Actions from "./actions";
import Getters from "./getters";

Vue.use(VueX);

const store = new VueX.Store({
    state: State,
    mutations: Mutations,
    actions: Actions,
    getters: Getters
});

export default store
