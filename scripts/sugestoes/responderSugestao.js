import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const responderSugestao = async (id) => {
  try {
    const response = await fetch(`${apiUrl}/pergunta-sugerida/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });

    if (!response.ok) return false;

    return true;
  } catch (error) {
    throw new Error(error.message);
  }
};
