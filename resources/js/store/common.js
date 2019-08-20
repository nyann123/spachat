const state = {
  loading: true,
  entering: false,
  header_height: 0,
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
  getHeader_height(state){
    return state.header_height
  },
}

const mutations = {
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

  setHeader_height(state, payload) {
    state.header_height = payload;
  }
}

const actions = {}

export default {
  state,
  getters,
  mutations,
  actions
}
