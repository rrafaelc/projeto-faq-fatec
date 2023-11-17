import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const atualizarContaUsuario = async ({
  senha_atual,
  nome_completo,
  email,
  senha,
  foto_uri,
}) => {
  const requestBody = {
    senha_atual,
    ...(nome_completo && { nome_completo }),
    ...(email && { email }),
    ...(senha && { senha }),
    ...(foto_uri && { foto_uri }),
  };

  try {
    const response = await fetch(`${apiUrl}/usuario`, {
      method: 'PATCH',
      body: JSON.stringify(requestBody),
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
