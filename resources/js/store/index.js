import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";

import common from './common'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    common
  },
  plugins: [createPersistedState()]
})

export default store