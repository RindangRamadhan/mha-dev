import Index from '../pages/index'
import Home from '../pages/dashboard'
import Logout from '../pages/logout'
import User from '../pages/user'
import UserCreate from '../pages/user/create'
import UserEdit from '../pages/user/edit'
import Iklan from '../pages/iklan'
import IklanCreate from '../pages/iklan/create'
import IklanEdit from '../pages/iklan/edit'

const routes = [
      {
        path: '/',
        name: 'index',
        component: Index
      },
      {
        path: '/home',
        name: 'home',
        component: Home,
        meta: {
            requiresAuth: true,
        }
      },
      {
        path: '/user',
        name: 'user',
        component: User,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/user/create',
        name: 'user_create',
        component: UserCreate,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/user/edit/:id',
        name: 'user_edit',
        component: UserEdit,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/iklan',
        name: 'iklan',
        component: Iklan,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/iklan/create',
        name: 'iklan_create',
        component: IklanCreate,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/iklan/edit/:id',
        name: 'iklan_edit',
        component: IklanEdit,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/logout',
        name: 'logout',
        component: Logout
      },
    ]

export default routes
