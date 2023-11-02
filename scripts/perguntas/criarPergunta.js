import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const criarPergunta = async ({ pergunta, resposta, prioridade }) => {
  try {
    const response = await fetch(`${apiUrl}/pergunta`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: getAuthorization(),
      },
      body: JSON.stringify({
        pergunta,
        resposta,
        prioridade,
      }),
    });

    if (!response.ok) return false;
  } catch (error) {
    console.log(error);
    return false;
  }

  return true;
};