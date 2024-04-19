import axios from 'axios'
import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    id: null,
    token: null,
    name:null,
    email: null,
    avatar: null,
    role_id: null,
    password: null
  }),
  // could also be defined as
  // state: () => ({ count: 0 })
  actions: {
    async setUserDetails(res, noImage) {
        this.$state.token = res.data.token
        console.log("token: ", res.data.token);
        this.$state.id = res.data.user.id
        this.$state.name = res.data.user.name
        this.$state.email = res.data.user.email
        this.$state.role_id = res.data.user.role_id
        this.$state.password = res.data.password

        if (res.data.user.avatar) {
          this.$state.avatar = res.data.user.avatar
        } else if (!noImage) {
          this.$state.avatar = 'http://127.0.0.1:8000/img/avatars/default.png'
        }
    },

    async fetchUser() {
        let res = await axios.get('api/users/' + this.$state.id)

        this.$state.id = res.data.user.id
        this.$state.name = res.data.user.name
        this.$state.email = res.data.user.email
        this.$state.role_id = res.data.user.role_id
        this.$state.token = res.data.token

        if (res.data.user.avatar) {
          this.$state.avatar = res.data.user.avatar
        } else {
          this.$state.avatar = 'http://127.0.0.1:8000/img/avatars/default.png'
        }
    },

    userImage(avatar) {
        return avatar
    },

    clearUser() {
        this.$state.id = null
        this.$state.token = null
        this.$state.name = null
        this.$state.email = null
        this.$state.avatar = null
        this.$state.role_id = null

    }
  },
  persist: true,
})
