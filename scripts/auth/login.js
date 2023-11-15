import { apiUrl } from '../constants/apiUrl.js';

export const login = async ({ email, senha }) => {
  localStorage.clear();

  try {
    const response = await fetch(`${apiUrl}/auth/login`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ email, senha }),
    });

    const responseData = await response.json();

    if (response.status === 403) {
      console.log(responseData);
      throw new Error(responseData.errors[0]);
    }

    if (!response.ok) {
      console.log(responseData);
      throw new Error(responseData.errors[0]);
    }

    if (
      responseData.id &&
      responseData.cargo &&
      responseData.access_token &&
      responseData.refresh_token &&
      responseData.expires_in
    ) {
      localStorage.setItem('id', responseData.id);
      localStorage.setItem('cargo', responseData.cargo);
      localStorage.setItem('access_token', responseData.access_token);
      localStorage.setItem('access_token_expires_in', responseData.access_token_expires_in);
      localStorage.setItem('refresh_token', responseData.refresh_token);
      localStorage.setItem('expires_in', responseData.expires_in);
    }
  } catch (error) {
    console.log(error);
    throw new Error(error.message);
  }
};
