import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

export const listarPerguntasPorUsuario = async ({
  pagina = 1,
  qtdPorPg = 5,
  order = 'asc',
} = {}) => {
  try {
    const response = await fetch(
      `${apiUrl}/pergunta/usuario?pagina=${pagina}&quantidade_por_pagina=${qtdPorPg}&order=${order}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          Authorization: await getAuthorization(),
        },
      },
    );

    const perguntas = await response.json();

    return perguntas;
  } catch (error) {
    throw new Error(error.message);
  }
};
