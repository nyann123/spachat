const state = ()=> ({
  loading: true,
  user: {
    id: '',
    name: '',
    taken: '',
  },
})

const getters = {
  getLoading(state){
    return state.loading
  },

  getUser(state){
    return state.user
  },
}

const mutations = {
  // stateInit(state){
  //   state.loading = true,
  //   state.user = {
  //     name: '',
  //     id: '',
  //   }
  // },

  setLoading(state, payload) {
    state.loading = payload;
  },
  
  setUser(state, payload) {
    state.user.id = payload.id;
    state.user.name = payload.name;
    state.user.taken = payload.taken;
  },
}

const actions = {}

export default {
  state,
  getters,
  mutations,
  actions
}
