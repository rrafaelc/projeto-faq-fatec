import { apiUrl } from '../constants/apiUrl.js';

export const isLoggedIn = async () => {
  const refreshToken = localStorage.getItem('refresh_token');

  if (!refreshToken) {
    localStorage.clear();

    return false;
  }

  try {
    const response = await fetch(`${apiUrl}/auth/refresh_token`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ refresh_token: refreshToken }),
    });

    const responseData = await response.json();

    if (response.status >= 400 && response.status < 500) {
      localStorage.clear();

      return false;
    }

    if (responseData.access_token && responseData.refresh_token && responseData.expires_in) {
      localStorage.setItem('access_token', responseData.access_token);
      localStorage.setItem('refresh_token', responseData.refresh_token);
      localStorage.setItem('expires_in', responseData.expires_in);
    }
  } catch (error) {
    localStorage.clear();

    return false;
  }

  return true;
};
