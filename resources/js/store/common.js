const state = {
  loading: true,
  entering: false,
  user: {
    name: '',
    id: '',
  },
}

const getters = {
  getLoading(state){
    return state.loading
  },
  getEntering(state){
    return state.entering
  },
  getUser(state){
    return state.user
  },
}

const mutations = {
  stateInit(state){
    state.loading = true,
    state.entering = false,
    state.user = {
      name: '',
      id: '',
    }
  },

  setLoading(state, payload) {
    state.loading = payload;
  },
  
  setEntering(state, payload) {
    state.entering = payload;
  },

  setUser(state, payload) {
    state.user.name = payload.name;
    state.user.id = payload.id;
  },
}

const actions = {}

export default {
  state,
  getters,
  mutations,
  actions
}
