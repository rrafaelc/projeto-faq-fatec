import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const deletarPergunta = async (id) => {
  try {
    const response = await fetch(`${apiUrl}/pergunta/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });

    if (response.status === 403) {
      const err = await response.json();
      console.log(err);
      throw new Error(err.errors[0]);
    }

    if (!response.ok) {
      const err = await response.json();
      console.log(err);
      throw new Error(err.errors[0]);
    }
  } catch (error) {
    throw new Error(error.message);
  }
};
