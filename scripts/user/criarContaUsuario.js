import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const criarContaUsuario = async ({ nome_completo, email, senha, cargo }) => {
  try {
    const response = await fetch(`${apiUrl}/usuario`, {
      method: 'POST',
      body: JSON.stringify({
        nome_completo,
        email,
        senha,
        cargo,
      }),
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });

    if (response.status === 403) throw new Error('Acesso negado');

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
