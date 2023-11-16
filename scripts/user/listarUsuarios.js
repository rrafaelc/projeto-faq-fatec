import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const listarUsuarios = async () => {
  try {
    const response = await fetch(`${apiUrl}/usuario`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });

    if (!response.ok) {
      throw new Error('Houve um erro ao carregar os usuários');
    }

    const data = await response.json();

    return data;
  } catch (error) {
    console.log(error);
  }
};
