import { apiUrl } from '../constants/apiUrl.js';

export const criarPrimeiraConta = async ({ nome_completo, email, senha }) => {
  try {
    await fetch(`${apiUrl}/criar-primeira-conta`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ nome_completo, email, senha }),
    });
  } catch (error) {
    throw new Error(error);
  }
};
