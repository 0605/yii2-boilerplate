const viewedTabsKey = 'ag:admin-viewed-tabs'

const tabs = {
  namespaced: true,
  state: {
    viewed: [],
    cached: [],
    current: null,
  },
  getters: {
    getViewed: (state) => {
      return state.viewed
    },
    getCached: (state) => {
      return state.cached
    },
    getCurrent: (state) => {
      return state.current
    },
    getNext: (state) => (tab) => {
      const matchIndex = state.viewed.findIndex(
        (view) => view.path === tab.path
      )

      let next = null

      if (matchIndex - 1 in state.viewed) {
        next = state.viewed[matchIndex - 1]
      } else if (matchIndex + 1 in state.viewed) {
        next = state.viewed[matchIndex + 1]
      } else {
        next = state.viewed.find((view) => view.affix)
      }

      return next
    },
  },
  mutations: {
    UPDATE_VIEWED: (state, tab) => {
      const matchIndex = state.viewed.findIndex((view) => {
        if (tab.path === view.path) {
          return true
        }

        if (tab.parent && tab.parent.path === view.path) {
          return true
        }

        if (view.parent && view.parent.path === tab.path) {
          return true
        }

        if (view.parent && tab.parent && view.parent.path === tab.parent.path) {
          return true
        }

        return false
      })

      if (matchIndex > -1) {
        state.viewed[matchIndex].name = tab.name
        state.viewed[matchIndex].path = tab.path
        state.viewed[matchIndex].query = tab.query
        state.viewed[matchIndex].parent = tab.parent
      } else {
        const currentIndex = state.viewed.findIndex(
          (view) => view.path === (state.current ? state.current.path : '')
        )

        state.viewed.splice(currentIndex + 1, 0, tab)
      }

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    UPDATE_CACHED: (state, tab) => {
      if (!tab) {
        return
      }

      if (!state.cached.includes(tab.name)) {
        state.cached.push(tab.name)
      }

      if (tab.parent) {
        if (!state.cached.includes(tab.parent.name)) {
          state.cached.push(tab.parent.name)
        }
      }
    },
    DELETE_CACHED: (state, name) => {
      if (!name) {
        return
      }

      if (Array.isArray(name)) {
        state.viewed = state.viewed.filter((view) => {
          return !name.includes(view.name)
        })
      } else {
        const matchIndex = state.cached.indexOf(name)

        if (matchIndex > -1) {
          state.cached.splice(matchIndex, 1)
        }
      }
    },
    DELETE_VIEWED: (state, tab) => {
      for (const [index, view] of state.viewed.entries()) {
        if (view.path === tab.path) {
          state.viewed.splice(index, 1)
          break
        }
      }

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    INIT_VIEWED: (state) => {
      const viewedTabs = window.localStorage.getItem(viewedTabsKey)

      if (viewedTabs && viewedTabs.length > 0) {
        state.viewed = JSON.parse(viewedTabs)
      }
    },
    UPDATE_CURRENT: (state, tab) => {
      state.current = tab
    },
    DELETE_OTHER_VIEWED: (state, tab) => {
      state.viewed = state.viewed.filter((view) => {
        return view.affix || view.path === tab.path
      })

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    DELETE_ALL_VIEWED: (state) => {
      state.viewed = state.viewed.filter((view) => {
        return view.affix
      })

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    DEL_OTHER_CACHED: (state, tab) => {
      if (!tab) {
        return
      }

      const matchIndex = state.cachedViews.indexOf(tab.name)

      if (matchIndex > -1) {
        state.cachedViews = state.cachedViews.slice(matchIndex, matchIndex + 1)
      } else {
        state.cachedViews = []
      }
    },
    DEL_ALL_CACHED_: (state) => {
      state.cachedViews = []
    },
  },
  actions: {
    init({ commit }) {
      commit('INIT_VIEWED')
    },
    current({ commit }, tab) {
      commit('UPDATE_CURRENT', tab)
    },
    open({ commit }, tab) {
      commit('UPDATE_VIEWED', tab)
      commit('UPDATE_CURRENT', tab)
      commit('UPDATE_CACHED', tab)
    },
    deleteCache({ commit }, name) {
      commit('DELETE_CACHED', name)
    },
    closeOther({ commit }, tab) {
      commit('DELETE_OTHER_VIEWED', tab)
      commit('DELETE_OTHER_CACHED', tab)
    },
    closeAll({ commit, state }) {
      commit('DELETE_ALL_VIEWED')
      commit('DELETE_ALL_CACHED')

      const next = state.viewed.find((view) => view.affix)

      return new Promise((resolve) => {
        resolve(next)
      })
    },
    close({ commit, state, getters }, tab) {
      const next = getters.getNext(tab)

      commit('DELETE_VIEWED', tab)
      commit('DELETE_CACHED', tab)

      return new Promise((resolve) => {
        resolve(next)
      })
    },
  },
}

export default tabs
