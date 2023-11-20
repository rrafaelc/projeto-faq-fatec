import { apiUrl } from '../constants/apiUrl.js';

export const listarPerguntas = async ({
  maisAlta = true,
  pagina = 1,
  qtdPorPg = 5,
  order = 'asc',
  titulo = '',
} = {}) => {
  try {
    const response = await fetch(
      `${apiUrl}/pergunta?mais-alta=${maisAlta}&pagina=${pagina}&quantidade_por_pagina=${qtdPorPg}&order=${order}&titulo=${titulo}`,
      {
        method: 'GET',
      },
    );

    const perguntas = await response.json();

    return perguntas;
  } catch (error) {
    throw new Error(error.message);
  }
};
