import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const deletarPergunta = async (id) => {
  try {
    await fetch(`${apiUrl}/pergunta/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });
  } catch (error) {
    throw new Error(error.message);
  }
};
