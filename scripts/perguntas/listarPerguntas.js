import { apiUrl } from '../constants/apiUrl.js';

export const listarPerguntas = async () => {
  try {
    const perguntas = await fetch(`${apiUrl}/pergunta`, {
      method: 'GET',
    });

    return perguntas.json();
  } catch (error) {
    throw new Error(error.message);
  }
};
