import Vue from 'vue'

const AuthService = {
  login(credentials) {
    return Vue.http.post('auth/login', credentials)
  },
  logout() {
    return Vue.http.post('auth/logout')
  },
  account() {
    return Vue.http.get('auth/account', null, false)
  },
  profile(profile = null) {
    const endpoint = 'auth/profile'

    if (profile === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.put(endpoint, profile)
  },
}

export default AuthService
