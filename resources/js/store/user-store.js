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
    password: null,
    city: null
  }),
  // could also be defined as
  // state: () => ({ count: 0 })
  actions: {
    async setUserDetails(res, noImage) {
        if (res.data.user.id != null) {
            this.$state.id = res.data.user.id
        }
        if (res.data.user.name != null) {
            this.$state.name = res.data.user.name
        }
        if (res.data.user.email != null) {
            this.$state.email = res.data.user.email
        }
        if (res.data.user.role_id != null) {
            this.$state.role_id = res.data.user.role_id
        }
        if (res.data.token != null) {
            this.$state.token = res.data.token
        }
        if (res.data.password != null) {
            this.$state.password = res.data.password
        }

        if (res.data.user.avatar != null) {

          this.$state.avatar = res.data.user.avatar
        } else if (!noImage) {
          this.$state.avatar = '/img/avatars/default.png'
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
          this.$state.avatar = '/img/avatars/default.png'
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
