import { apiUrl } from '../constants/apiUrl.js';

export const temUsuarios = async () => {
  try {
    const response = await fetch(`${apiUrl}/tem-usuarios`);

    return response.json();
  } catch (error) {
    console.log(error);
  }
};
