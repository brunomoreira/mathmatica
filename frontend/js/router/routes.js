import Welcome from '../components/Welcome'
import Register from '../components/Register'
import Login from '../components/Login'
import Profile from '../components/Profile'
import Help from '../components/Help'
import Test from '../components/Test'

const routes = [
    { path: '/welcome', name: 'welcome', component: Welcome },
    { path: '/register', name: 'register', component: Register },
    { path: '/login', name: 'login', component: Login },
    { path: '/profile', name: 'profile', component: Profile, meta: { requiresAuth: true } },
    { path: '/help', name: 'help', component: Help },
    { path: '/test', name: 'test', component: Test },
    { path: '*', redirect: { name:'welcome' } }
]

export default routes