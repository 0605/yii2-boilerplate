const accessTokenItemKey = 'bp-admin-access-token'
const clientIdItemKey = 'bp-admin-client-id'

import { deepSearch, formatUrl } from '@admin/utils/Utils'

const app = {
  strict: process.env.NODE_ENV !== 'production',
  state: {
    device: 'desktop',
    sidebar: {
      collapsed: false,
      hidden: false
    },
    auth: {
      clientId: '',
      loginModal: false,
      get accessToken() {
        return window.localStorage.getItem(accessTokenItemKey)
      }
    },
    user: {
      init: false,
      displayName: '',
      displayIcon: '',
      groupAcl: [],
      groupMenus: []
    }
  },
  getters: {
    checkAcl: (state) => (route) => {
      return state.user.groupAcl.includes(route)
    },
    checkInMenu: (state, getters) => (route) => {
      const menus = getters.deepSearchMenus(state)
      const path = route.startsWith('/') ? route.substr(1) : route

      return menus.map(menu => formatUrl(menu)).includes(path)
    },
    deepSearchMenus: (state) => () => {
      return deepSearch('url', state.user.groupMenus)
    }
  },
  mutations: {
    INIT_CLIENT_ID: (state) => {
      let clientId = window.localStorage.getItem(clientIdItemKey)

      if (clientId == null) {
        clientId = Math.random().toString(36).substr(2)

        window.localStorage.setItem(clientIdItemKey, clientId)
      }

      state.auth.clientId = clientId
    },
    TOGGLE_DEVICE: (state, device) => {
      state.device = device
    },
    TOGGLE_SIDEBAR: state => {
      state.sidebar.collapsed = !state.sidebar.collapsed
    },
    TOGGLE_LOGIN_MODAL: (state, visible) => {
      if (state.auth.loginModal === visible) {
        return
      }

      state.auth.loginModal = visible
    },
    UPDATE_ACCESS_TOKEN: (state, accessToken) => {
      if (accessToken !== null) {
        window.localStorage.setItem(accessTokenItemKey, accessToken)
      } else {
        window.localStorage.removeItem(accessTokenItemKey)
      }
    },
    UPDATE_USER: (state, user) => {
      if (user == null) {
        state.user.init = false
        state.user.displayName = ''
        state.user.displayIcon = ''
        state.user.groupAcl = []
        state.user.groupMenus = []
      } else {
        state.user = user
        state.user.init = true
      }
    }
  },
  actions: {
    toggleSidebar({ commit }) {
      commit('TOGGLE_SIDEBAR')
    },
    toggleDevice({ commit }, device) {
      commit('TOGGLE_DEVICE', device)
    },
    toggleLoginModal({ commit }, visible) {
      commit('TOGGLE_LOGIN_MODAL', visible)
    },
    updateAccessToken({ commit }, accessToken) {
      commit('UPDATE_ACCESS_TOKEN', accessToken)
    },
    updateUser({ commit }, user) {
      commit('UPDATE_USER', user)
    }
  }
}

export default app
