import { refreshToken } from '../utils/refreshToken.js';

export const isLoggedIn = async () => {
  const refresh_token = localStorage.getItem('refresh_token');
  const access_token = localStorage.getItem('access_token');
  const access_token_expires_in = localStorage.getItem('access_token_expires_in');

  if (!refresh_token || !access_token) {
    localStorage.clear();

    return false;
  }

  if (new Date() > new Date(access_token_expires_in)) {
    const response = await refreshToken();

    if (!response) {
      localStorage.clear();

      return false;
    }
  }

  return true;
};
