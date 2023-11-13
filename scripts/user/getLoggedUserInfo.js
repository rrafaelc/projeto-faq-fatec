import { apiUrl } from '../constants/apiUrl.js';
import { serverUrl } from '../constants/serverUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const getLoggedUseInfo = async () => {
  const userId = localStorage.getItem('id');

  try {
    const response = await fetch(`${apiUrl}/usuario/${userId}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });

    if (!response.ok) {
      localStorage.clear();
      window.location = `${serverUrl}/login`;
    }

    const data = await response.json();

    return {
      id: data.id,
      nome_completo: data.nome_completo,
      email: data.email,
      foto_uri: data.foto_uri,
      cargo: data.cargo,
      esta_suspenso: data.esta_suspenso,
    };
  } catch (error) {
    console.log(error);
  }
};
