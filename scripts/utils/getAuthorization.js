import { refreshToken } from './refreshToken.js';

export const getAuthorization = async () => {
  const access_token_expires_in = localStorage.getItem('access_token_expires_in');

  if (new Date() > new Date(access_token_expires_in)) {
    await refreshToken();
  }

  const access_token = localStorage.getItem('access_token');

  return `Bearer ${access_token}`;
};
