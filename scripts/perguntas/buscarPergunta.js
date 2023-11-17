import { apiUrl } from '../constants/apiUrl.js';

export const buscarPergunta = async ({ id }) => {
  try {
    const response = await fetch(`${apiUrl}/pergunta/${id}`, {
      method: 'GET',
    });

    if (!response.ok) {
      const err = await response.json();
      console.log(err);
      throw new Error(err.errors[0]);
    }

    const pergunta = await response.json();

    return pergunta;
  } catch (error) {
    console.log(error);
    throw new Error(error.message);
  }
};
