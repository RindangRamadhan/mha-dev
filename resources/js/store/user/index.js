import { LOGIN, LOGOUT, SET_USERS } from './mutations'

const state = {
    users: [],
    profile : {},
    loggedIn : false,
    is_admin : false,
    is_owner : false,
    is_member: false
}

const getters = {
  
}

const mutations = {
    [LOGIN] (state, user) {
      if(user.role.role_id == "1"){
       state.is_owner = true
      }else if(user.role.role_id == "2"){
       state.is_admin = true
      }else{
       state.is_member = true
      }
      state.loggedIn = true
      state.profile = user 
    },

    [LOGOUT] (state) {
      state.is_admin = false
      state.is_owner = false
      state.is_member = false
      state.loggedIn = false
      state.profile = {}
    },

    [SET_USERS] (state,users) {
      state.users = users
    }
}

const actions = {

  LOAD_USERS : function({commit}){
    axios.get('api/users/all')
    .then((resp) => {
      commit(SET_USERS,resp.data)
    },
    (err) => {
      console.log(err)
    })
  }

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}


