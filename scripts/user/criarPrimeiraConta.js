import { apiUrl } from '../constants/apiUrl.js';

export const criarPrimeiraConta = async ({ nome_completo, email, senha, captchaToken = '' }) => {
  try {
    const response = await fetch(`${apiUrl}/criar-primeira-conta`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ nome_completo, email, senha, captchaToken }),
    });

    const responseData = await response.json().catch(() => ({}));

    if (!response.ok) {
      const msg =
        responseData.errors?.[0] ||
        responseData.message ||
        'Não foi possível criar a conta';
      throw new Error(msg);
    }
  } catch (error) {
    throw new Error(error instanceof Error ? error.message : String(error));
  }
};
