import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const suspenderContaUsuario = async ({ id, esta_suspenso }) => {
  try {
    const response = await fetch(`${apiUrl}/usuario/suspender/${id}`, {
      method: 'POST',
      body: JSON.stringify({
        esta_suspenso,
      }),
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });

    if (response.status === 403) {
      const err = await response.json();
      console.log(err);
      throw new Error(err.errors[0]);
    }

    if (!response.ok) {
      const err = await response.json();
      console.log(err);
      throw new Error(err.errors[0]);
    }
  } catch (error) {
    console.log(error);
    throw new Error(error.message);
  }
};
