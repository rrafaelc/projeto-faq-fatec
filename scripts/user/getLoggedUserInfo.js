import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const getLoggedUseInfo = async () => {
  const userId = localStorage.getItem('id');

  try {
    const response = await fetch(`${apiUrl}/usuario/${userId}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: getAuthorization(),
      },
    });

    const data = await response.json();

    return {
      id: data.id,
      nome_completo: data.nome_completo,
      ra: data.ra,
      email: data.email,
      foto_uri: data.foto_uri,
      cargo: data.cargo,
      esta_suspenso: data.esta_suspenso,
    };
  } catch (error) {
    console.log(error);
  }
};
