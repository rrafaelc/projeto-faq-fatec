import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const listarUsuarios = async ({ pagina = 1, qtdPorPg = 5, order = 'asc' } = {}) => {
  try {
    const response = await fetch(
      `${apiUrl}/usuario?pagina=${pagina}&quantidade_por_pagina=${qtdPorPg}&order=${order}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          Authorization: await getAuthorization(),
        },
      },
    );

    if (!response.ok) {
      const err = await response.json();
      console.log(err);
      throw new Error(err.errors[0]);
    }

    const data = await response.json();

    return data;
  } catch (error) {
    console.log(error);
    throw new Error(error.message);
  }
};
