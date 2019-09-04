import Vue from 'vue'
import Router from 'vue-router'
import { ifAuthenticated, ifNotAuthenticated } from '../utils/auth';

// Containers
import MainContainer from '../containers/MainContainer';
import AuthContainer from '../containers/AuthContainer';

// Auth
import Login from '../views/Auth/Login';
import SignUp from '../views/Auth/SignUp';
import Dashboard from '../views/Dashboard/index';

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      redirect: '/dashboard',
      component: MainContainer,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/dashboard',
      component: MainContainer,
      children: [
        {
          path: '/',
          name: 'Home',
          component: Dashboard
        }
      ],
      beforeEnter: ifAuthenticated
    },
    {
      path: '/auth',
      name: 'Auth',
      component: AuthContainer,
      children: [
        {
          path: 'login',
          name: 'Login',
          component: Login,
          beforeEnter: ifNotAuthenticated
        },
        {
          path: 'register',
          name: 'SignUp',
          component: SignUp,
          beforeEnter: ifNotAuthenticated
        }
      ]
    }
  ]
})
