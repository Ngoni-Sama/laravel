export const UPDATE_USER_INFO = (state, userInfo) => {
  state.userInfo.id = userInfo.id ? userInfo.id : '';
  state.userInfo.email = userInfo.email ? userInfo.email : '';
  state.userInfo.name = userInfo.name ? userInfo.name : '';
  state.userInfo.verifiedAt = userInfo.verifiedAt ? userInfo.verifiedAt : null;
};

export const LOG_IN = (state, token) => {
  state.token = (token && token.accessToken) || '';
  state.tokenExpiresIn = (token && token.expiresIn) || '';
  state.refreshTokenExpiresIn = (token && token.refreshTokenExpiresIn) || '';
};

export const LOG_OUT = (state) => {
  state.token = null;
  state.tokenExpiresIn = null;
  state.refreshTokenExpiresIn = null;
  state.userInfo = {};
};