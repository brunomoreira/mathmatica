import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import VueMaterial from 'vue-material'
import Vuelidate from 'vuelidate'
import axios from 'axios'

Vue.use(VueMaterial)
Vue.use(Vuelidate)

Vue.config.productionTip = false

// Check if user has session
window.onload = () => {

  axios.get('/user/session').then(response => {

    const data = response.data

    const user = data.hasSession ? data.session : null

    store.commit('changeUser', user)

  })

}

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App),
  template: '<App/>',
  components: { App }
})