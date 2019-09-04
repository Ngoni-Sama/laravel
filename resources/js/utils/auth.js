import store from '../store';
import axios from '../axios';

export const checkValidToken = (tokenExpiresIn) => {
  if (tokenExpiresIn) {
    if (new Date(tokenExpiresIn) > Date.now()) {
      return true;
    }
  }
  return false;
};

export const ifAuthenticated = (to, from, next) => {
  if (store.state.token != null && checkValidToken(store.state.tokenExpiresIn)) {
    next();
    return;
  }
  next('/auth/login');
};

export const ifNotAuthenticated = (to, from, next) => {
  if (store.state.token === null || !checkValidToken(store.state.tokenExpiresIn)) {
    next();
    return;
  }
  next('/dashboard');
};

export const isAuthenticated = () => {
  return store.state.token != null && checkValidToken(store.state.tokenExpiresIn);
};

export const handleLogin = (userInfo, token) => {
  store.dispatch('login', token);
  store.dispatch('updateUserInfo', userInfo);
  axios.defaults.headers['Authorization'] = 'Bearer ' + token.accessToken;
};

export const handleLogout = () => {
  store.dispatch('logout');
  delete axios.defaults.headers['Authorization'];
};

