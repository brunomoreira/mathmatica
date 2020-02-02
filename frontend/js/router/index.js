import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'

import routes from './routes'
import axios from 'axios'

Vue.use(VueRouter)

const Router = new VueRouter({
    mode: 'history',
    routes
})

Router.beforeEach((to, from, next) => {

    store.commit('changeLoading', true)
    const user = store.state.user

    // Protect routes that require authentication
    if(to.meta.requiresAuth) {
        
        if(user == null) {
            return next({
                path: '/login'
            })
        }

    }
    
    // If user is logged in - block the login and register routes
    if(user !== null) {

        if(to.path == '/login' || to.path == '/register') {
            
            return next({
                path: '/welcome'
            })

        }
    
    }

    // We always need to call next()
    return next()

})

Router.afterEach((to, from) => {
    store.commit('changeLoading', false)
})

export default Router