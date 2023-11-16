import { apiUrl } from '../constants/apiUrl.js';

export const listarPerguntasMaisBuscadas = async () => {
  try {
    const perguntas = await fetch(`${apiUrl}/pergunta/mais-buscados`, {
      method: 'GET',
    });

    return perguntas.json();
  } catch (error) {
    throw new Error(error.message);
  }
};
