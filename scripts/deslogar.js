import { apiUrl } from './constants/apiUrl.js';
import { serverUrl } from './constants/serverUrl.js';
import { isLoggedIn } from './middlewares/isLoggedIn.js';

export const deslogar = async () => {
  const loggedIn = await isLoggedIn();

  if (loggedIn) {
    const access_token = localStorage.getItem('access_token');

    try {
      const response = await fetch(`${apiUrl}/auth/logout`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer ${access_token}`,
        },
      });

      if (response.status >= 400 && response.status < 500) {
        localStorage.clear();
        window.location.href = `${serverUrl}/login`;
      }

      localStorage.clear();
      window.location.href = `${serverUrl}/login`;
    } catch (error) {
      localStorage.clear();
      window.location.href = `${serverUrl}/login`;
    }

    localStorage.clear();
    window.location.href = `${serverUrl}/login`;
  } else {
    localStorage.clear();
    window.location.href = `${serverUrl}/login`;
  }
};
