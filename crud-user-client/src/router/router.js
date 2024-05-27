import Login from '@/components/AppLogin.vue'
import Register from '@/components/AppRegister.vue'
import Home from '@/components/AppHome.vue'
import Dashboard from '@/components/AppDashboard.vue'

export const route = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/home',
    redirect: '/'
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      roles: ['admin']
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]