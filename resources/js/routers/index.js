import Index from '../pages/index'
import Home from '../pages/dashboard'
import Logout from '../pages/logout'
import User from '../pages/user'
import UserCreate from '../pages/user/create'
import UserEdit from '../pages/user/edit'

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
        path: '/logout',
        name: 'logout',
        component: Logout
      },
    ]

export default routes
