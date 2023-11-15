import { apiUrl } from '../constants/apiUrl.js';
export const decrementarCurtidas = async (id) => {
  try {
    const perguntas = await fetch(`${apiUrl}/pergunta/decrementar-curtidas/${id}`, {
      method: 'PATCH',
    });

    return perguntas.json();
  } catch (error) {
    throw new Error(error.message);
  }
};


