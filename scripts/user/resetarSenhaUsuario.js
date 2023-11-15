import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const resetarSenhaUsuario = async ({ id }) => {
  try {
    const response = await fetch(`${apiUrl}/usuario/resetar-senha/${id}`, {
      method: 'PATCH',
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

    const { nova_senha } = await response.json();

    return nova_senha;
  } catch (error) {
    console.log(error);
    throw new Error(error.message);
  }
};
