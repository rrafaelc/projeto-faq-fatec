import { apiUrl } from '../constants/apiUrl.js';
export const incrementarCurtidas = async (id) => {
  try {
    const perguntas = await fetch(`${apiUrl}/pergunta/incrementar-curtidas/${id}`, {
      method: 'PATCH',
    });

    return perguntas.json();
  } catch (error) {
    throw new Error(error.message);
  }
};


