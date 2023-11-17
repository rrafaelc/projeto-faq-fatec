import { apiUrl } from '../constants/apiUrl.js';

export const getTotaisPerguntas = async () => {
  try {
    const perguntas = await fetch(`${apiUrl}/pergunta/totais`, {
      method: 'GET',
    });

    return perguntas.json();
  } catch (error) {
    throw new Error(error.message);
  }
};
