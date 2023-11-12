import { apiUrl } from '../constants/apiUrl.js';

export const criarSugestao = async ({ nome, email, telefone, pergunta }) => {
  try {
    const response = await fetch(`${apiUrl}/pergunta-sugerida`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        nome,
        email,
        telefone,
        pergunta,
      }),
    });

    if (!response.ok) return false;

    return true;
  } catch (err) {
    throw new Error(err.message);
  }
};
